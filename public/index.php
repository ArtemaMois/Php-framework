<?php

use App\Services\UserService;
use Doctrine\DBAL\Connection;
use League\Container\Container;
use Timon\PhpFramework\Http\Kernel\Kernel;
use Timon\PhpFramework\Http\Request\Request;

define('APP_PATH', dirname(__DIR__));
require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * @var Container container
 */
$request = Request::createFromGlobals();
$container = require APP_PATH.'/config/services.php';
$kernel = $container->get(Kernel::class);
$service = new UserService($container->get(Connection::class));
$service->findByEmail('ivan@tymon.s');
$response = $kernel->handle($request);
$response->send();


