<?php
namespace App\Http;

use FastRoute;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Framework\Exceptions\ModelNotFoundException;
use Framework\Http\Response;

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
            $r->addRoute('POST', '/users', [Controllers\UsersController::class, 'store']);
            $r->addRoute('PATCH', '/users/{id}', [Controllers\UsersController::class, 'update']);
            $r->addRoute('DELETE', '/users/{id}', [Controllers\UsersController::class, 'destroy']);
        });
    }

    public function handle($method, $uri)
    {
        $route = $this->dispatcher->dispatch($method, $uri);

        switch ($route[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                $this->serveNotFound();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $this->serveNotAllowed();
                break;
            case FastRoute\Dispatcher::FOUND:
                $controller = $route[1];
                $parameters = $route[2];
                try {
                    $response = $this->container->call($controller, $parameters);
                    $response->serve();
                } catch (ModelNotFoundException $e) {
                    $this->serveNotFound();
                }
                break;
        }
    }

    protected function serveNotFound()
    {
        $response = new Response(json_encode(['error' => 'Resource not found']));
        $response->setStatusCode(404);
        $response->addHeader('Content-Type', 'application/json');
        $response->serve();
    }

    protected function serveNotAllowed()
    {
        $response = new Response(json_encode(['error' => 'Method not allowed']));
        $response->setStatusCode(405);
        $response->addHeader('Content-Type', 'application/json');
        $response->serve();
    }
}
