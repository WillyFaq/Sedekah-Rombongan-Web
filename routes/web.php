<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, "index"]);

Route::resource('/category', CategoryController::class);
Route::resource('/user', UserController::class);
Route::get('/user/{user:id}/reset', [UserController::class, "resetpassword"]);
