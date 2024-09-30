<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\HouseController;
use App\Http\Controllers\Api\HouseHistoryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\Spendingcontroller;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth', 'admin')->group(function () {
        // Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        // Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
    });
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::apiResource('/house-histories', HouseHistoryController::class);
Route::apiResource('/spendings', Spendingcontroller::class);
Route::apiResource('/payments', PaymentController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/houses', HouseController::class);
Route::get('/bar-chart', [ChartController::class, 'barChart']);
Route::apiResource('/categories', CategoryController::class);
