<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\DsnParser;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;
use Timon\PhpFramework\Console\Application;
use Timon\PhpFramework\Console\Command\MigrateCommand;
use Timon\PhpFramework\Console\Command\RollbackCommand;
use Timon\PhpFramework\Console\Command\TestStartCommand;
use Timon\PhpFramework\Console\Kernel as ConsoleKernel;
use Timon\PhpFramework\Dbal\ConnectionFactory;
use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Kernel\Kernel;
use Timon\PhpFramework\Http\Middleware\RequestHandler;
use Timon\PhpFramework\Http\Middleware\RequestHandlerInterface;
use Timon\PhpFramework\Http\Middleware\RouterDispatch;
use Timon\PhpFramework\Routing\Router\Router;
use Timon\PhpFramework\Routing\Router\RouterInterface;
use Timon\PhpFramework\Session\Session;
use Timon\PhpFramework\Session\SessionInterface;
use Timon\PhpFramework\Template\TwigFactory;

$routes = include APP_PATH . '/routes/web.php';
$container = new Container;

$container->delegate(new ReflectionContainer(true));
$container->addShared(Container::class, $container);

// настройка env
$env = new Dotenv;
$env->load(APP_PATH . '/.env');
$appEnv = $_ENV['APP_ENV'] ?? 'local';
$container->add('APP_ENV', new StringArgument($appEnv));

// настройка database
$parser = new DsnParser;
$databaseUrl = 'pdo-mysql://lemp:lemp@database:3306/lemp?charset=utf8mb4';
$container->add(ConnectionFactory::class)->addArgument(new ArrayArgument($parser->parse($databaseUrl)));
$container->addShared(Connection::class, function () use ($container) {
    return $container->get(ConnectionFactory::class)->create();
});

// настройка console command
$container->add('framework-commands-namespace', new StringArgument('Timon\\PhpFramework\\Console\\Command\\'));
$container->add(Application::class)->addArgument($container);
$container->add(ConsoleKernel::class)->addArgument($container)->addArgument(Application::class);
$container->add('console:migrate', MigrateCommand::class)
    ->addArgument($container->get(Connection::class))
    ->addArgument(new StringArgument(APP_PATH . '/database/migrations/'));
$container->add('console:migrate-rollback', RollbackCommand::class)
    ->addArgument($container->get(Connection::class))
    ->addArgument(new StringArgument(APP_PATH . '/database/migrations/'));
$container->add('console:test', TestStartCommand::class);

// настройка router
$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('register', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
->addArguments([
    RouterInterface::class,
    Container::class,
    RequestHandlerInterface::class
]);

// настройка RequestHandler
$container->add(RequestHandlerInterface::class, RequestHandler::class)->addArgument($container); 

// настройка routerDispatcher
$container->add(RouterDispatch::class)->addArgument($container)->addArgument(RouterInterface::class);

// настройка сессий
$container->addShared(SessionInterface::class, Session::class);

// настройка views
$viewsPath = APP_PATH . '/views';
$container->add('twig-factory', TwigFactory::class)->addArguments([new StringArgument($viewsPath), SessionInterface::class]);
$container->addShared('twig', function () use ($container) {
    return $container->get('twig-factory')->create();
});

// настройка контроллера
$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

// настройка Request
return $container;
