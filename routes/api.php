<?php

use App\Http\Controllers\v1\AdminController;
use App\Http\Controllers\v1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logoutAll', [AuthController::class, 'logoutAll']);
    Route::get('profile', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard']);
    Route::get('users', [AdminController::class, 'users']);
    Route::get('users/{user}', [AdminController::class, 'show']);
    Route::put('users/{user}', [AdminController::class, 'update']);
    Route::post('register', [AdminController::class, 'register']);
    Route::delete('users/{user}', [AdminController::class, 'destroy']);
});
