<?php

namespace Anomalyce\Interlocutor;

use Closure;
use Throwable;
use Illuminate\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Anomalyce\Interlocutor\Contracts\{ Driver, Endpoint, Engine };

class Interlocutor
{
  /**
   * Holds the Interlocutor implementation.
   * 
   * @var \Anomalyce\Interlocutor\Interlocutor|null
   */
  protected static ?Interlocutor $instance = null;

  /**
   * Holds the engine implementation.
   * 
   * @var \Anomalyce\Interlocutor\Contracts\Engine 
   */
  protected Engine $engine;

  /**
   * Holds the driver configuration options.
   * 
   * @var array
   */
  protected static array $drivers = [];

  /**
   * Instantiate a new interlocutor object.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Engine  $engine
   * @return void
   */
  public function __construct(Engine $engine)
  {
    $this->engine = $engine;

    static::$instance = $this;
  }

  /**
   * Create or retrieve the current Interlocutor implementation.
   * 
   * @return $this
   * 
   * @throws \Anomalyce\Interlocutor\InterlocutorException
   */
  public static function getInstance(): self
  {
    if (static::$instance instanceof self) {
      return static::$instance;
    }

    throw new InterlocutorException('You must first instantiate an Interlocutor object.', 501);
  }

  /**
   * Send a request using an endpoint.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Endpoint  $endpoint
   * @return mixed
   */
  public function send(Endpoint $endpoint): mixed
  {
    $driver = $endpoint->throughDriver();

    $driver->configuration($this->getDriverConfiguration($driver));

    try {
      $pipes = array_filter([ $driver, $endpoint ]);

      $request = (new Pipeline)
        ->send($this->engine->build($endpoint, $driver))
        ->through($pipes)
        ->via('interjectRequest')
        ->thenReturn();

      $response = (new Pipeline)
        ->send($this->engine->execute($request, $endpoint, $driver)->getBody()->getContents())
        ->through($pipes)
        ->via('transformResponse')
        ->thenReturn();

      return $response;
    } catch (Throwable $exception) {
      foreach (array_reverse($pipes) as $pipe) {
        $exception = $pipe->handleExceptions($exception);

        if (! ($exception instanceof Throwable)) {
          return $exception;
        }
      }

      throw $exception;
    }
  }

  /**
   * Set the configuration options for a specific driver.
   * 
   * @param  string  $driver
   * @param  array  $options  []
   * @return void
   */
  public static function configure(string $driver, array $options = []): void
  {
    static::$drivers[$driver] = array_merge_recursive(static::$drivers[$driver] ?? [], $options);
  }

  /**
   * Retrieve the configuration options for a specific driver.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Driver  $driver
   * @return array
   */
  protected function getDriverConfiguration(Driver $driver): array
  {
    $className = get_class($driver);

    if (! isset(static::$drivers[$className])) {
      return [];
    }

    return static::$drivers[$className];
  }
}
