<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/FreeIpApi.php';

use Anomalyce\Interlocutor\{ Interlocutor, Engines };

$interlocutor = new Interlocutor(new Engines\GuzzleHttp);

$request = new \Examples\FreeIpApi('185.213.154.234');

$response = $request->send();

print_r($response);
