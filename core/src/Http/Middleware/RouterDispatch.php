<?php 

namespace Timon\PhpFramework\Http\Middleware;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;
use Timon\PhpFramework\Routing\Router\Router;
use Timon\PhpFramework\Routing\Router\RouterInterface;

class RouterDispatch implements MiddlewareInterface
{
    public function __construct(
        private ContainerInterface $container,
        private RouterInterface $router
    ) {}
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        [$routeHandler, $params] = $this->router->dispatch($request, $this->container);
        $response = call_user_func_array($routeHandler, $params);
        return $response;
    }
}