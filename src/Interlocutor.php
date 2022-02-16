<?php

namespace Anomalyce\Interlocutor;

use Throwable;
use Illuminate\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Anomalyce\Interlocutor\Contracts\{ Endpoint, Engine };

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
   * @param  ...  $arguments
   * @return $this
   */
  public static function getInstance(...$arguments): self
  {
    if (static::$instance instanceof self) {
      return static::$instance;
    }

    return new self(...$arguments);
  }

  /**
   * Send a request using an endpoint.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Endpoint  $endpoint
   * @return mixed
   */
  public function send(Endpoint $endpoint): mixed
  {
    try {
      $pipes = array_filter([ $endpoint->throughDriver(), $endpoint ]);

      $request = (new Pipeline)
        ->send($this->engine->build($endpoint))
        ->through($pipes)
        ->via('interjectRequest')
        ->thenReturn();

      $response = (new Pipeline)
        ->send($this->engine->execute($request)->getBody()->getContents())
        ->through($pipes)
        ->via('transformResponse')
        ->thenReturn();

      return $response;
    } catch (InterlocutorException $e) {
      $exception = (new Pipeline)
        ->send($e)
        ->through(array_filter([ $endpoint, $endpoint->throughDriver() ]))
        ->via('handleExceptions')
        ->thenReturn();

      if (! ($exception instanceof Throwable)) {
        return null;
      }

      throw $exception;
    }
  }
}
