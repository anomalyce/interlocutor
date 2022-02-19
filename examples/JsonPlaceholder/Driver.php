<?php

namespace Examples\JsonPlaceholder;

use Throwable;
use Psr\Http\Message\{ ResponseInterface, RequestInterface };
use Anomalyce\Interlocutor\{ Contracts, InterlocutorException };

class Driver implements Contracts\Driver
{
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
    //
  }

  /**
   * Declare the base URL to use.
   * 
   * @return string
   */
  public function baseUrl(): string
  {
    return 'https://jsonplaceholder.typicode.com';
  }

  /**
   * Declare the global data to send along with your request.
   * 
   * @return array
   */
  public function data(): array
  {
    return [];
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
    return json_decode($response, true);
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
