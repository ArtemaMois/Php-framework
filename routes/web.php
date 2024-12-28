<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Timon\PhpFramework\Routing\Route\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/create', [PostsController::class, 'create']),
    Route::get('/posts/{id}', [HomeController::class, 'posts']),
];
