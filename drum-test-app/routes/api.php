<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('', [TaskController::class, 'index']);
    Route::post('', [TaskController::class, 'store']);
    Route::delete('', [TaskController::class, 'destroy']);
    Route::put('/{taskId}', [TaskController::class, 'update']);
    Route::post('/set-completed', [TaskController::class, 'setTaskCompleted']);
});
