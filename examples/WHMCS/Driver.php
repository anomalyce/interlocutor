<?php

namespace Examples\WHMCS;

use Throwable;
use Psr\Http\Message\{ ResponseInterface, RequestInterface };
use Anomalyce\Interlocutor\{ Contracts, InterlocutorException };

class Driver implements Contracts\Driver
{
  /**
   * Holds the driver configuration options.
   * 
   * @var array
   */
  protected array $options = [];

  /**
   * Catch the configuration options passed to the driver from the outside.
   * 
   * @see \Anomalyce\Interlocutor\Interlocutor::configure()
   * 
   * @param  array  $options  []
   * @return void
   */
  public function configuration(array $options = []): void
  {
    $this->options = $options;
  }

  /**
   * Declare the base URL to use.
   * 
   * @return string
   */
  public function baseUrl(): string
  {
    return $this->options['url'];
  }

  /**
   * Declare the global data to send along with your request.
   * 
   * @return array
   */
  public function data(): array
  {
    return [
      'identifier'    => $this->options['identifier'],
      'secret'        => $this->options['secret'],
      'responsetype'  => 'json',
    ];
  }

  /**
   * Declare the global HTTP headers to use.
   * 
   * @return array
   */
  public function headers(): array
  {
    return [
      'Accept' => 'application/json',
    ];
  }

  /**
   * Interject the request.
   * 
   * @return \Psr\Http\Message\RequestInterface
   */
  public function interjectRequest(RequestInterface $request): RequestInterface
  {
    return $request;
  }

  /**
   * Transform the response.
   * 
   * @return mixed
   */
  public function transformResponse(mixed $response): mixed
  {
    $response = json_decode($response, true);

    if (isset($response['result'], $response['message']) and strtolower($response['result']) === 'error') {
      throw new InterlocutorException($response['message'], 422);
    }

    return $response;
  }

  /**
   * Handle any exceptions.
   * 
   * @param  \Throwable  $exception
   * @return mixed
   */
  public function handleExceptions(Throwable $exception): mixed
  {
    return $exception;
  }
}
