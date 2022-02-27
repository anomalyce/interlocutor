<?php

namespace Anomalyce\Interlocutor;

use ReflectionClass;
use RuntimeException;

trait Interlocutory
{
  /**
   * Send the endpoint object through the Interlocutor.
   * 
   * @param  ... $arguments
   * @return mixed
   */
  public function send(...$arguments): mixed
  {
    $this->detectInterlocutoryConstructors();

    return Interlocutor::getInstance()->send(
      $this, $arguments
    );
  }

  /**
   * Throws an exception in case any alternative constructors were found (using the #[constructor] attribute).
   * 
   * @return void
   * 
   * @throws \RuntimeException
   */
  protected function detectInterlocutoryConstructors(): void
  {
    $exception = false;

    $constructors = [];

    foreach ((new ReflectionClass($this))->getMethods() as $method) {
      if (! ($attributes = $method->getAttributes())) {
        continue;
      }

      foreach ($attributes as $attribute) {
        if (! preg_match('/constructor/i', $attribute->getName())) {
          continue;
        }

        $constructors[] = $method->getName();

        if (! isset(debug_backtrace()[2])) {
          $exception = true;
        }
      }
    }

    if ($exception) {
      throw new RuntimeException(sprintf(
        'The endpoint is configured for multiple scenarios, use one of the alternative constructors (%s) instead of the default send method.',
        implode(', ', $constructors)
      ));
    }
  }
}
