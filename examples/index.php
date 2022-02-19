<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/FreeIpApi.php';
require_once __DIR__.'/JsonPlaceholder/Driver.php';
require_once __DIR__.'/JsonPlaceholder/GetPosts.php';
require_once __DIR__.'/JsonPlaceholder/CreatePost.php';
require_once __DIR__.'/WHMCS/Driver.php';
require_once __DIR__.'/WHMCS/Endpoints/GetClients.php';

use Anomalyce\Interlocutor\{ Interlocutor, Engines };

$interlocutor = new Interlocutor(new Engines\GuzzleHttp);

Interlocutor::configure(\Examples\WHMCS\Driver::class, [
  'url'         => 'https://whmcs/includes/api.php',
  'identifier'  => 'your-whmcs-api-identifier-here',
  'secret'      => 'your-whmcs-api-secret-here',
]);

$request = new \Examples\WHMCS\Endpoints\GetClients('Closed');

$response = $request->send();

print_r($response);
