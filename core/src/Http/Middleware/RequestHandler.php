<?php 

namespace Timon\PhpFramework\Http\Middleware;

use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middlewares = [
        Authenticate::class,
        Success::class
    ];
    public function handle(Request $request): Response
    {
        if(empty($this->middlewares))
        {
            return new Response('SERVER ERROR', [], 500);
        }
        /**
         * @var MiddlewareInterface middlewareClass
         */
        $middlewareClass = array_shift($this->middlewares);
        return (new $middlewareClass())->process($request, $this);
    }
}