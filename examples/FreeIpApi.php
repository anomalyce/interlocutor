<?php

namespace Examples;

use Throwable;
use Psr\Http\Message\{ ResponseInterface, RequestInterface };
use Anomalyce\Interlocutor\{ Contracts, InterlocutorException, Communicates };

class FreeIpApi implements Contracts\Endpoint
{
  use Communicates;

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
    return "https://freeipapi.com/api/json/{$this->ipaddress}";
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
   * @param  \Anomalyce\Interlocutor\InterlocutorException  $exception
   * @return \Throwable|null
   */
  public function handleExceptions(InterlocutorException $exception): ?Throwable
  {
    return $exception;
  }
}
