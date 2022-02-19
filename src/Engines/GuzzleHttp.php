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
   * Holds the GuzzleHttp client implementation.
   * 
   * @var \GuzzleHttp\Client
   */
  protected Client $client;

  /**
   * Instantiate a new engine object.
   * 
   * @param  array  $options  []
   * @return void
   */
  public function __construct(protected array $options = [])
  {
    $this->client = new Client($this->options);
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
    $url = $endpoint->url($driver?->baseUrl());

    $headers = $endpoint->headers($driver?->headers() ?? []);

    return new Request($endpoint->method()->name, $url, $headers);
  }

  /**
   * Execute the HTTP request.
   * 
   * @param  \Psr\Http\Message\RequestInterface  $request
   * @param  \Anomalyce\Interlocutor\Contracts\Endpoint  $endpoint
   * @param  \Anomalyce\Interlocutor\Contracts\Driver|null  $driver  null
   * @return \Psr\Http\Message\ResponseInterface
   * 
   * @throws \Anomalyce\Interlocutor\InterlocutorException
   */
  public function execute(RequestInterface $request, Endpoint $endpoint, ?Driver $driver = null): ResponseInterface
  {
    try {
      $options = [];

      if (! in_array($endpoint->method(), [ HttpVerb::GET, HttpVerb::HEAD, HttpVerb::OPTIONS ])) {
        $data = $endpoint->data($driver?->data() ?? []);

        if (is_string($data)) {
          $options['json'] = $data;
        } else {
          $options['form_params'] = $data ?? [];
        }
      }

      return $this->client->send($request, $options);
    } catch (GuzzleException $e) {
      throw new InterlocutorException($e->getMessage(), $e->getCode(), $e);
    }
  }
}
