<?php

namespace Anomalyce\Interlocutor\Contracts;

use Throwable;
use Anomalyce\Interlocutor\InterlocutorException;
use Psr\Http\Message\{ ResponseInterface, RequestInterface };

interface Driver
{
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
   * @return \Psr\Http\Message\RequestInterface
   */
  public function interjectRequest(RequestInterface $request): RequestInterface;

  /**
   * Transform the response.
   * 
   * @return mixed
   */
  public function transformResponse(mixed $response): mixed;

  /**
   * Handle any exceptions.
   * 
   * @param  \Anomalyce\Interlocutor\InterlocutorException  $exception
   * @return \Throwable|null
   */
  public function handleExceptions(InterlocutorException $exception): ?Throwable;
}
