<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tasks\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Auth
    Route::post('login', [AuthController::class, 'login']);
});

// Manager routes
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    // Tasks
    Route::prefix('tasks')->group(function () {
        Route::get('', [TasksController::class, 'index']);
        Route::get('{id}', [TasksController::class, 'show']);
        Route::post('', [TasksController::class, 'store']);
        Route::put('{id}', [TasksController::class, 'update']);
        Route::delete('{id}', [TasksController::class, 'destroy']);
    });

    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
});