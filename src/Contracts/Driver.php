<?php

namespace Anomalyce\Interlocutor\Contracts;

use Closure;
use Throwable;
use Psr\Http\Message\RequestInterface;

interface Driver
{
  /**
   * Catch the configuration options passed to the driver from the outside.
   * 
   * @see \Anomalyce\Interlocutor\Interlocutor::configure()
   * 
   * @param  array  $options  []
   * @return void
   */
  public function configuration(array $options = []): void;

  /**
   * Declare the base URL to use.
   * 
   * @return string
   */
  public function baseUrl(): string;

  /**
   * Declare the global data to send along with your request.
   * 
   * @return array
   */
  public function data(): array;

  /**
   * Declare the global HTTP headers to use.
   * 
   * @return array
   */
  public function headers(): array;

  /**
   * Interject the request.
   * 
   * @param  \Psr\Http\Message\RequestInterface  $request
   * @param  \Closure  $next
   * @return \Psr\Http\Message\RequestInterface
   */
  public function interjectRequest(RequestInterface $request, Closure $next): RequestInterface;

  /**
   * Transform the response.
   * 
   * @param  mixed  $response
   * @param  \Closure  $next
   * @return mixed
   */
  public function transformResponse(mixed $response, Closure $next): mixed;

  /**
   * Handle any exceptions.
   * 
   * @param  \Throwable  $exception
   * @return mixed
   */
  public function handleExceptions(Throwable $exception): mixed;
}
