<?php

use App\Http\Controllers\HomeController;
use Timon\PhpFramework\Routing\Route\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id}', [HomeController::class, 'posts']),
    Route::get('/hi', function () {
        return response()->json(['data' => '1posq23']);
    }),
];
