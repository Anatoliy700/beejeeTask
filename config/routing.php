<?php

use app\controllers\AuthController;
use app\controllers\TaskController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => [TaskController::class, 'indexAction']])
);
$routes->add(
    'create',
    new Route('/task/create', ['_controller' => [TaskController::class, 'createAction']])
);

$routes->add(
    'view',
    new Route('/task/view/{id<\d+>}', ['_controller' => [TaskController::class, 'viewAction']])
);

$routes->add(
    'update',
    new Route('/task/update/{id<\d+>}', ['_controller' => [TaskController::class, 'updateAction']])
);

$routes->add(
    'updateStatus',
    new Route('/task/update-status/{id<\d+>}', ['_controller' => [TaskController::class, 'updateStatusAction']])
);

$routes->add(
    'login',
    new Route('/auth/login', ['_controller' => [AuthController::class, 'authenticationAction']])
);

$routes->add(
    'logout',
    new Route('/auth/logout', ['_controller' => [AuthController::class, 'logoutAction']])
);

return $routes;
