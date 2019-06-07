<?php

/** @var $container \Symfony\Component\DependencyInjection\ContainerBuilder */


use Symfony\Component\DependencyInjection\Reference;

$container->register('db', \app\Services\Db::class)
    ->setArguments([
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'beejee',
        'charset' => 'utf8'
    ]);

$container->register('session', \Symfony\Component\HttpFoundation\Session\Session::class);

$container->register('user.security', \app\services\Security::class)
    ->addArgument(new Reference('session'));
