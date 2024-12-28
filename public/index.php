<?php

use Timon\PhpFramework\Http\Kernel\Kernel;

define('APP_PATH', dirname(__DIR__));
require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * @var League\Container\Container\Container @container
 */
$container = require APP_PATH.'/config/services.php';
$kernel = $container->get(Kernel::class);

$response = $kernel->handle();

$response->send();
