<?php

namespace Timon\PhpFramework\Http\Middleware;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middlewares = [
        StartSession::class,
        Authenticate::class,
        RouterDispatch::class
    ];

    public function __construct(
        private ContainerInterface $container
    ) {}


    /** @var MiddlewareInterface middlewareClass */
    
     public function handle(Request $request): Response
    {
        if (empty($this->middlewares)) {
            return new Response('SERVER ERROR', [], 500);
        }
        $middlewareClass = array_shift($this->middlewares);
        $middlewareInstance = $this->container->get($middlewareClass);
        return $middlewareInstance->process($request, $this);
    }
}
