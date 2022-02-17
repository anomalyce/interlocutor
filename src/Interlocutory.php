<?php

namespace Anomalyce\Interlocutor;

trait Interlocutory
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
