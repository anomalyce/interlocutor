<?php

namespace Examples\JsonPlaceholder\Endpoints;

use Closure;
use Throwable;
use Examples\JsonPlaceholder\Driver;
use Psr\Http\Message\RequestInterface;
use Anomalyce\Interlocutor\{ Contracts, Interlocutory };

class CreatePost implements Contracts\Endpoint
{
  use Interlocutory;

  /**
   * Create a full post.
   * 
   * @param  string  $title
   * @param  string  $body
   * @return mixed
   */
  #[constructor]
  public function full(string $title, string $body): mixed
  {
    return $this->send([
      'title' => $title,
      'body' => $body,
    ]);
  }

  /**
   * Create a short post.
   * 
   * @param  string  $title
   * @return mixed
   */
  #[constructor]
  public function short(string $title): mixed
  {
    return $this->send([
      'title' => $title,
    ]);
  }

  /**
   * Declare the HTTP method to use.
   * 
   * @return \Anomalyce\Interlocutor\Contracts\HttpVerb
   */
  public function method(): Contracts\HttpVerb
  {
    return Contracts\HttpVerb::POST;
  }

  /**
   * Declare the URL to use.
   * 
   * @parma  string  $baseUrl  null
   * @return string
   */
  public function url(string $baseUrl = null): string
  {
    return "{$baseUrl}/posts";
  }

  /**
   * Declare the data to send along with your request.
   * 
   * @param  array  $data  []
   * @return array|string|null
   */
  public function data(array $data = []): array|string|null
  {
    return json_encode(array_merge($data, [
      //
    ]));
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
    return $next($response);
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
