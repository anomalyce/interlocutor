<?php

namespace Examples\JsonPlaceholder;

use Throwable;
use Anomalyce\Interlocutor\{ Contracts, Interlocutory };
use Psr\Http\Message\{ ResponseInterface, RequestInterface };

class CreatePost implements Contracts\Endpoint
{
  use Interlocutory;

  /**
   * Instantiate a new endpoint object.
   * 
   * @param  string  $subject
   * @return void
   */
  public function __construct(protected string $subject)
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
    return "${baseUrl}/posts";
  }

  /**
   * Declare the data to send along with your request.
   * 
   * @param  array  $data  []
   * @return array|string|null
   */
  public function data(array $data = []): array|string|null
  {
    return json_encode([
      'subject' => $this->subject,
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel facilisis tellus. Curabitur posuere eros urna, vel fringilla justo condimentum tincidunt. Morbi condimentum nunc ut justo malesuada viverra. Sed pharetra vitae nibh nec sagittis. Phasellus ac porta urna. Nam quam eros, consequat vitae eros non, vehicula sodales est. Vestibulum nibh elit, malesuada ac fringilla quis, pharetra id lorem. In quis purus ultrices, lacinia justo sit amet, mollis mauris. Nam eget lacinia tortor, sit amet eleifend mi.',
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
