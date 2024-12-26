<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;
use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Kernel\Kernel;
use Timon\PhpFramework\Routing\Router\Router;
use Timon\PhpFramework\Routing\Router\RouterInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$routes = include APP_PATH.'/routes/web.php';
$container = new Container();

$container->delegate(new ReflectionContainer(true));

$env = new Dotenv();
$env->load(APP_PATH . "/.env");
$appEnv = $_ENV['APP_ENV'] ?? 'local';
$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->add(Container::class, $container);

$container->extend(RouterInterface::class)->addMethodCall('register', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class)->addArgument(Container::class);

$viewsPath = APP_PATH . "/views";
$container->addShared('twig-loader', FilesystemLoader::class)->addArgument(new StringArgument($viewsPath));
$container->addShared('twig', Environment::class)->addArgument('twig-loader');
$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);
return $container;
