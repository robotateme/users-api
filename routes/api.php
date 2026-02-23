<?php

use App\Http\Controllers\API\UsersController;
use App\Http\Middleware\RedisRateLimiterMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/users/register', [UsersController::class, 'register'])
    ->name('users.register')
    ->middleware('redis-rate-limiter:10:60');

Route::get('/users', [UsersController::class, 'index'])
    ->name('users.list')
    ->middleware('redis-rate-limiter:10,60');
