<?php

namespace Anomalyce\Interlocutor;

trait Communicates
{
  /**
   * Send the endpoint object through the Interlocutor.
   * 
   * @return mixed
   */
  public function send(): mixed
  {
    return Interlocutor::getInstance()->send($this);
  }
}
