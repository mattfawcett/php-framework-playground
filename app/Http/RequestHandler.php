<?php
namespace App\Http;

use FastRoute;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

/**
 * A class for handling a HTTP request
 */
class RequestHandler
{
    public function __construct($container)
    {
        $this->container = $container;

        $this->dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('GET', '/users', [Controllers\UsersController::class, 'index']);
            $r->addRoute('GET', '/users/{id}', [Controllers\UsersController::class, 'show']);
        });
    }

    public function handle($method, $uri)
    {
        $route = $this->dispatcher->dispatch($method, $uri);

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
                $response = $this->container->call($controller, $parameters);
                $response->serve();
                break;
        }
    }
}
