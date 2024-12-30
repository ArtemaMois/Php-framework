<?php 

namespace Timon\PhpFramework\Http\Middleware;

use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

class Success implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        return new Response('Hello, world');
    }
}
