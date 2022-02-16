<?php

namespace Anomalyce\Interlocutor\Contracts;

use Psr\Http\Message\{ ResponseInterface, RequestInterface };

interface Engine
{
  /**
   * Build the HTTP request.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Endpoint  $endpoint
   * @return \Psr\Http\Message\RequestInterface
   */
  public function build(Endpoint $endpoint): RequestInterface;

  /**
   * Execute the HTTP request.
   * 
   * @param  \Psr\Http\Message\RequestInterface  $request
   * @return \Psr\Http\Message\ResponseInterface
   * 
   * @throws \Anomalyce\Interlocutor\InterlocutorException
   */
  public function execute(RequestInterface $request): ResponseInterface;
}
