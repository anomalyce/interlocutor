<?php

namespace Anomalyce\Interlocutor\Contracts;

use Throwable;
use Anomalyce\Interlocutor\InterlocutorException;

interface Endpoint
{
  /**
   * Declare the HTTP method to use.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\HttpVerb
   */
  public function method(): HttpVerb;

  /**
   * Declare the URL to use.
   * 
   * @parma  string  $baseUrl  null
   * @return string
   */
  public function url(string $baseUrl = null): string;

  /**
   * Declare the data to send along with your request.
   * 
   * @param  array  $data  []
   * @return array
   */
  public function data(array $data = []): array;

  /**
   * Declare the HTTP headers to use.
   * 
   * @param  array  $headers  []
   * @return array
   */
  public function headers(array $headers = []): array;

  /**
   * Send the endpoint through a driver.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Driver|null
   */
  public function throughDriver(): ?Driver;

  /**
   * Interject the request.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Request
   */
  public function interjectRequest(Request $request): Request;

  /**
   * Transform the response.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Response
   */
  public function transformResponse(Response $response): Response;

  /**
   * Handle any exceptions.
   * 
   * @param  \Anomalyce\Interlocutor\InterlocutorException  $exception
   * @return \Throwable|null
   */
  public function handleExceptions(InterlocutorException $exception): ?Throwable;
}
