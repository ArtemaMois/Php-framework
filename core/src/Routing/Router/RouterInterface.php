<?php

namespace Timon\PhpFramework\Routing\Router;

use League\Container\Container;
use Timon\PhpFramework\Http\Request\Request;

interface RouterInterface
{
    public function register(array $routes);

    public function dispatch(Request $request, Container $container);
}
