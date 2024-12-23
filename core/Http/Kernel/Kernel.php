<?php

namespace Timon\PhpFramework\Http\Kernel;

use FastRoute\RouteCollector;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;
use Timon\PhpFramework\Routing\Router\Router;

use function FastRoute\simpleDispatcher;

class Kernel
{
    public function __construct() {}

    public function handle(Request $request)
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            Router::initRoutes($collector);
        });
        $routeInfo = $dispatcher->dispatch($request->method(), $request->uri());
        [$status, [$controller, $action], $params] = $routeInfo;
        return (new $controller())->$action($params); 
        // return $handler($params);
    }
}
