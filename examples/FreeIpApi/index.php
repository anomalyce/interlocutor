<?php

require_once __DIR__.'/../../index.php';

/**
 * @see https://freeipapi.com/
 */

use Anomalyce\Interlocutor\{ Interlocutor, Engines };

$interlocutor = new Interlocutor(new Engines\GuzzleHttp);

$request = new Examples\FreeIpApi\Geolocation(
  $_ENV['GEOLOCATION_IP'] ?? $_SERVER['REMOTE_ADDR']
);

$response = $request->send();

print_r($response);
