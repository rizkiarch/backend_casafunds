<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HouseController;
use App\Http\Controllers\Api\HouseHistoryController;
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
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/houses', HouseController::class);
Route::apiResource('/house-histories', HouseHistoryController::class);
