<?php

dataset('drivers', [
  'whmcs' => function () {
    return [
      'url' => 'https://whmcs/includes/api.php',
      'identifier' => 'api-identifier',
      'secret' => 'api-secret',
    ];
  },
]);
