<?php

namespace Examples\JsonPlaceholder;

use Closure;
use Throwable;
use Psr\Http\Message\RequestInterface;
use Anomalyce\Interlocutor\{ Contracts, InterlocutorException };

/**
 * @see https://jsonplaceholder.typicode.com/
 */
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
   * @param  \Psr\Http\Message\RequestInterface  $request
   * @param  \Closure  $next
   * @return \Psr\Http\Message\RequestInterface
   */
  public function interjectRequest(RequestInterface $request, Closure $next): RequestInterface
  {
    return $next($request);
  }

  /**
   * Transform the response.
   * 
   * @param  mixed  $response
   * @param  \Closure  $next
   * @return mixed
   */
  public function transformResponse(mixed $response, Closure $next): mixed
  {
    return $next(json_decode($response, true));
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
