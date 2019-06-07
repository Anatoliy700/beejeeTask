<?php

/** @var $container \Symfony\Component\DependencyInjection\ContainerBuilder */

$dbConfig = require __DIR__ . '/db.php';

use Symfony\Component\DependencyInjection\Reference;

$container->register('db', \app\Services\Db::class)
    ->setArguments($dbConfig);

$container->register('session', \Symfony\Component\HttpFoundation\Session\Session::class);

$container->register('user.security', \app\services\Security::class)
    ->addArgument(new Reference('session'));
