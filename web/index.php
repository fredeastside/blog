<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';

$env = getenv('SYMFONY_ENV');
$debug = true;

if ($env === 'prod') {
    include_once __DIR__.'/../var/bootstrap.php.cache';
    $debug = false;
} else {
    Debug::enable();
}

$kernel = new AppKernel($env, $debug);
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
