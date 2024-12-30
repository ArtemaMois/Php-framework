<?php 

namespace Timon\PhpFramework\Http\Middleware;

use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

class Authenticate implements MiddlewareInterface
{
    private bool $authenticated = true;
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if(!$this->authenticated)
        {
            return new Response('Authentication failed', [], 401);
        }
        return $handler->handle($request);
    }
}