<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Timon\PhpFramework\Routing\Route\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/create', [PostsController::class, 'create']),
    Route::post('/posts', [PostsController::class, 'store']),
    Route::get('/posts/{id}', [PostsController::class, 'show']),
    Route::get('/register', [AuthController::class, 'form']),
    Route::post('/register', [AuthController::class, 'register']),
    Route::get('/login', [AuthController::class, 'loginForm']),
    Route::post('/login', [AuthController::class, 'login']),
    Route::get('/dashboard', [DashBoardController::class, 'index']),
];
