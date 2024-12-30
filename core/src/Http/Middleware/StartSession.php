<?php

namespace Timon\PhpFramework\Http\Middleware;

use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;
use Timon\PhpFramework\Session\SessionInterface;

class StartSession implements MiddlewareInterface
{
    public function __construct(
        private SessionInterface $session,
    ) {}
    public function process(Request $request, RequestHandlerInterface $handler): Response 
    {
        $this->session->start();
        $request->setSession($this->session);
        return $handler->handle($request);
    }
}
