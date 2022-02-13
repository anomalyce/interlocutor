<?php

namespace Anomalyce\Interlocutor;

use Anomalyce\Interlocutor\Contracts\{ Endpoint, Engine, Response };

class Interlocutor
{
  /**
   * Holds the engine implementation.
   * 
   * @var \Anomalyce\Interlocutor\Contracts\Engine 
   */
  protected Engine $engine;

  /**
   * Instantiate a new interlocutor object.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Engine  $engine
   * @return void
   */
  public function __construct(Engine $engine)
  {
    $this->engine = $engine;
  }

  /**
   * Send a request using an endpoint.
   * 
   * @param  \Anomalyce\Interlocutor\Contracts\Endpoint  $endpoint
   * @return \Anomalyce\Interlocutor\Contracts\Response
   */
  public function send(Endpoint $endpoint): Response
  {
    //
  }
}
