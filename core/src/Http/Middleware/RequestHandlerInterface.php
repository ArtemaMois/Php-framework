<?php 

namespace Timon\PhpFramework\Http\Middleware;

use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

interface RequestHandlerInterface 
{
    public function handle(Request $request): Response;
}