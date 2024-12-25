<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Timon\PhpFramework\Http\Kernel\Kernel;
use Timon\PhpFramework\Routing\Router\Router;
use Timon\PhpFramework\Routing\Router\RouterInterface;


$routes = include APP_PATH.'/routes/web.php';
$container = new Container();
$container->delegate(new ReflectionContainer(true));
$container->add('APP_ENV', new StringArgument("production"));
$container->add(RouterInterface::class, Router::class);
$container->add(Container::class, $container);
$container->extend(RouterInterface::class)->addMethodCall('register', [new ArrayArgument($routes)]);
$container->add(Kernel::class)->addArgument(RouterInterface::class)->addArgument(Container::class);

return $container;
