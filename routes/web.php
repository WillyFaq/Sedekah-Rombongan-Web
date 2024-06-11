<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, "index"]);

Route::resource('/category', CategoryController::class);
Route::get('/user/{user:id}/reset', [UserController::class, "resetpassword"]);
Route::resource('/user', UserController::class);
Route::post('/project/upload', [ProjectController::class, "uploadfromeditor"]);
Route::resource('/project', ProjectController::class);
Route::get('/donation/{donation:id}/invoice', [DonationController::class, "invoice"]);
Route::resource('/donation', DonationController::class);
