<?php

require_once __DIR__.'/../../index.php';

/**
 * @see https://developers.whmcs.com/api/authentication/
 * @see https://developers.whmcs.com/api/api-index/
 */

use Examples\WHMCS\{ Driver, Endpoints };
use Anomalyce\Interlocutor\{ Interlocutor, Engines };

$interlocutor = new Interlocutor(new Engines\GuzzleHttp);

Interlocutor::configure(Driver::class, [
  'url'         => $_ENV['WHMCS_URL']         ?? 'https://whmcs/includes/api.php',
  'identifier'  => $_ENV['WHMCS_IDENTIFIER']  ?? 'your-api-identifier-here',
  'secret'      => $_ENV['WHMCS_SECRET']      ?? 'your-api-secret-here',
]);

// GetClients
print_r((new Endpoints\GetClients('Active'))->send());
