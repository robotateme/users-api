<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/users/register', [UsersController::class, 'register']);
Route::get('/users', [UsersController::class, 'index']);
