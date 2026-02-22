<?php

use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/users/register', [UsersController::class, 'register'])
    ->name('users.register')
    ->middleware('throttle:register');

Route::get('/users', [UsersController::class, 'index'])
    ->name('users.list')
    ->middleware('throttle:users-list');
