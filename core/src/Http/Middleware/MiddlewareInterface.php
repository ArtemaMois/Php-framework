<?php

namespace Timon\PhpFramework\Http\Middleware;

use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

interface MiddlewareInterface 
{
    public function process(Request $request, RequestHandlerInterface $handler): Response;
}