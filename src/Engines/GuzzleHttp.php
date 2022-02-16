<?php

namespace Anomalyce\Interlocutor\Engines;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use Anomalyce\Interlocutor\InterlocutorException;
use Psr\Http\Message\{ ResponseInterface, RequestInterface };
use Anomalyce\Interlocutor\Contracts\{ Driver, Endpoint, Engine, HttpVerb };

class GuzzleHttp implements Engine
{
  /**
   * Instantiate a new engine object.
   * 
   * @param  array  $options  []
   * @return void
   */
  public function __construct(protected array $options = [])
  {
    //
  }

  /**
   * Build the HTTP request.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Endpoint  $endpoint
   * @param  \Anomalyce\Interlocutor\Contracts\Driver|null  $driver  null
   * @return \Psr\Http\Message\RequestInterface
   */
  public function build(Endpoint $endpoint, ?Driver $driver = null): RequestInterface
  {
    $method = $endpoint->method();

    $url = $endpoint->url($driver?->baseUrl());

    $headers = $endpoint->headers($driver?->headers() ?? []);

    $options = [ 'headers' => $headers ];

    if (! in_array($method, [ HttpVerb::GET, HttpVerb::HEAD, HttpVerb::OPTIONS ])) {
      $options['form_params'] = $endpoint->data($driver?->data() ?? []);
    }

    return new Request($method->name, $url, array_filter($options));
  }

  /**
   * Execute the HTTP request.
   * 
   * @param  \Psr\Http\Message\RequestInterface  $request
   * @return \Psr\Http\Message\ResponseInterface
   * 
   * @throws \Anomalyce\Interlocutor\InterlocutorException
   */
  public function execute(RequestInterface $request): ResponseInterface
  {
    try {
      $client = new Client($this->options);

      return $client->send($request);
    } catch (GuzzleException $e) {
      throw new InterlocutorException($e->getMessage(), $e->getCode(), $e);
    }
  }
}
