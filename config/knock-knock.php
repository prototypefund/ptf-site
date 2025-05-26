<?php

use craft\helpers\App;

return [
  '*' => [
    'enabled' => false,
    'enableCpProtection' => false
  ],
  'production' => [
    'enabled' => App::env('KNOCK_KNOCK_ENABLED'),
    'enableCpProtection' => true,
    'password' => App::env('KNOCK_KNOCK_PASSWORD'),
  ],
  'staging' => [
    'enabled' => App::env('KNOCK_KNOCK_ENABLED'),
    'enableCpProtection' => true,
    'password' => App::env('KNOCK_KNOCK_PASSWORD'),
  ],
];
