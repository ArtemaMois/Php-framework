<?php

namespace Timon\PhpFramework\Routing\Router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use League\Container\Container;
use Timon\PhpFramework\Http\Exceptions\MethodNotAllowedException;
use Timon\PhpFramework\Http\Exceptions\PageNotFoundException;
use Timon\PhpFramework\Http\Request\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes = [];

    private Dispatcher $dispatcher;

    private function initRoutes(RouteCollector $collector)
    {
        foreach ($this->routes as $route) {
            $collector->addRoute(...$route);
        }
    }

    public function register(array $routes)
    {
        $this->routes = $routes;
        $this->initDispatcher();
        // dd($this->routes);
    }

    public function dispatch(Request $request, Container $container)
    {
        $routeInfo = $this->dispatcher->dispatch($request->method(), $request->uri());
        [$handler, $params] = $this->defineRouteInfo($routeInfo);
        if (is_array($handler)) {
            [$controllerId, $action] = $handler;
            $controller = $container->get($controllerId);
            $handler = [new $controller, $action];
        }

        return [$handler, $params];
    }

    private function initDispatcher()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $this->initRoutes($collector);
        });
    }

    private function defineRouteInfo(array $routeInfo)
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw (new PageNotFoundException('Page Not Found 404'));
            case Dispatcher::METHOD_NOT_ALLOWED:
                $methods = $routeInfo[1];
                throw (new MethodNotAllowedException('Supported methods for this route is: '.implode(', ', $methods)));
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
        }

    }
}
