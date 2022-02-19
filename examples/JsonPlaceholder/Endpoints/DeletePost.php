<?php

namespace Examples\JsonPlaceholder\Endpoints;

use Throwable;
use Examples\JsonPlaceholder\Driver;
use Psr\Http\Message\RequestInterface;
use Anomalyce\Interlocutor\{ Contracts, Interlocutory };

class DeletePost implements Contracts\Endpoint
{
  use Interlocutory;

  /**
   * Instantiate a new endpoint object.
   * 
   * @param  integer  $post
   * @return void
   */
  public function __construct(protected int $post)
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
    return Contracts\HttpVerb::DELETE;
  }

  /**
   * Declare the URL to use.
   * 
   * @parma  string  $baseUrl  null
   * @return string
   */
  public function url(string $baseUrl = null): string
  {
    return "{$baseUrl}/posts/{$this->post}";
  }

  /**
   * Declare the data to send along with your request.
   * 
   * @param  array  $data  []
   * @return array|string|null
   */
  public function data(array $data = []): array|string|null
  {
    return array_merge($data, [
      //
    ]);
  }

  /**
   * Declare the HTTP headers to use.
   * 
   * @param  array  $headers  []
   * @return array
   */
  public function headers(array $headers = []): array
  {
    return array_merge($headers, [
      //
    ]);
  }

  /**
   * Send the endpoint through a driver.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\Driver|null
   */
  public function throughDriver(): ?Contracts\Driver
  {
    return new Driver;
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
