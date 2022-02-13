<?php

namespace Examples;

use Throwable;
use Anomalyce\Interlocutor\{ Contracts, InterlocutorException };

class FreeIpApi implements Contracts\Endpoint
{
  /**
   * Instantiate a new endpoint object.
   * 
   * @param  string  $ipaddress
   * @return void
   */
  public function __construct(protected string $ipaddress)
  {
    //
  }

  /**
   * Declare the HTTP method to use.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\HttpVerb
   */
  public function method(): Contracts\HttpVerb
  {
    return Contracts\HttpVerb::GET;
  }

  /**
   * Declare the URL to use.
   * 
   * @parma  string  $baseUrl  null
   * @return string
   */
  public function url(string $baseUrl = null): string
  {
    return "https://freeipapi.com/api/json/${this->ipaddress}";
  }

  /**
   * Declare the data to send along with your request.
   * 
   * @param  array  $data  []
   * @return array
   */
  public function data(array $data = []): array
  {
    return [];
  }

  /**
   * Declare the HTTP headers to use.
   * 
   * @param  array  $headers  []
   * @return array
   */
  public function headers(array $headers = []): array
  {
    return [];
  }

  /**
   * Send the endpoint through a driver.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Driver|null
   */
  public function throughDriver(): ?Contracts\Driver
  {
    return null;
  }

  /**
   * Interject the request.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Request
   */
  public function interjectRequest(Contracts\Request $request): Contracts\Request
  {
    return $request;
  }

  /**
   * Transform the response.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Response
   */
  public function transformResponse(Contracts\Response $response): Contracts\Response
  {
    return $response;
  }

  /**
   * Handle any exceptions.
   * 
   * @param  \Anomalyce\Interlocutor\InterlocutorException  $exception
   * @return \Throwable|null
   */
  public function handleExceptions(InterlocutorException $exception): ?Throwable
  {
    return $exception;
  }
}