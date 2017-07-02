<?php
namespace App;

use FastRoute;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

$container = require_once(__DIR__ . '/app/bootstrap.php');

$userRepository = $container->get(UserRepository::class);


$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/users', [Http\Controllers\UsersController::class, 'index']);
    $r->addRoute('GET', '/users/{id}', [Http\Controllers\UsersController::class, 'show']);
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);


switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $container->call($controller, $parameters);
        break;
}
