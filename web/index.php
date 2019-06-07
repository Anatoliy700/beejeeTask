<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Framework\Registry;
use Framework\App;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$request = Request::createFromGlobals();

$containerBuilder = new ContainerBuilder();
$containerBuilder->set('request', $request);

Registry::addContainer($containerBuilder);

$response = (new App($containerBuilder))->handle();
$response->send();
