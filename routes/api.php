<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/category', [CategoryController::class, "index"]);
Route::get('/category/{category:id}', [CategoryController::class, "show"]);
// Route::apiResource('/category', CategoryController::class);
Route::get('/project', [ProjectController::class, "index"]);
Route::get('/project/{project:slug}', [ProjectController::class, "show"]);
// Route::apiResource('/project', ProjectController::class);
Route::get('/comments/project/{project:slug}', [CommentController::class, "byproject"]);
Route::get('/donations/project/{project:slug}', [DonationController::class, "byproject"]);

Route::post('/user', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);
    Route::delete('/user/logout', [UserController::class, 'logout']);

    Route::apiResource('/comments', CommentController::class);
    Route::apiResource('/donations', DonationController::class);
});
