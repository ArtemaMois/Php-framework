<?php 

namespace Timon\PhpFramework\Routing\Router;

use FastRoute\RouteCollector;

class Router
{
    public static function initRoutes(RouteCollector $collector)
    {
        $routes = include APP_PATH . '/routes/web.php';
        foreach($routes as $route)
        {
            $collector->addRoute(...$route);
        }
    }
}