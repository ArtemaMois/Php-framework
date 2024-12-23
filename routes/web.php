<?php

use App\Http\Controllers\HomeController;
use Timon\PhpFramework\Routing\Route\Route;

return [
    Route::get('/', [HomeController::class, 'index']),

];
