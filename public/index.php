<?php

use Timon\PhpFramework\Http\Kernel\Kernel;
use Timon\PhpFramework\Http\Request\Request;


define('APP_PATH', dirname(__DIR__));
require_once dirname(__DIR__).'/vendor/autoload.php';

$kernel = new Kernel();

return $kernel->handle(Request::createFromGlobals());
