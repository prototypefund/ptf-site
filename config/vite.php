<?php

use craft\helpers\App;

return [
  'useDevServer' => App::env('ENVIRONMENT') === 'dev' || App::env('CRAFT_ENVIRONMENT') === 'dev',
	'devServerInternal' => 'http://localhost:5173',
	'devServerPublic' => App::env('PRIMARY_SITE_URL') . ':5173',
	'serverPublic' => App::env('PRIMARY_SITE_URL') . '/static/dist/',
  'manifestPath' => '@webroot/static/dist/manifest.json',
  'errorEntry' => '',
  'cacheKeySuffix' => '',
  'includeReactRefreshShim' => false,
  'includeModulePreloadShim' => true,
];
