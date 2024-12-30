<?php

use Timon\PhpFramework\Http\Kernel\Kernel;
use Timon\PhpFramework\Http\Request\Request;

define('APP_PATH', dirname(__DIR__));
require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * @var League\Container\Container\Container @container
 */
$request = Request::createFromGlobals();
$container = require APP_PATH.'/config/services.php';
$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();
