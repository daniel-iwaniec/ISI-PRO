<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$apc = extension_loaded('apc') && ini_get('apc.enabled');
$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';

if ($apc) {
    $apcLoader = new ApcClassLoader('edu_management', $loader);
    $loader->unregister();
    $apcLoader->register(true);
}

require_once __DIR__ . '/../app/AppKernel.php';
if ($apc) {
    require_once __DIR__ . '/../app/AppCache.php';
}

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
if ($apc) {
    $kernel = new AppCache($kernel);
}

if ($apc) {
    Request::enableHttpMethodParameterOverride();
}
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
