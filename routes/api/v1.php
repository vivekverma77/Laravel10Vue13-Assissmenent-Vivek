<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\CompleteTaskController;
use App\Http\Controllers\Api\V1\UserController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
    Route::get('/tasks/tasksByStatus/{status}', [TaskController::class, 'tasksByStatus']);
    Route::post('/tasks/tasksBySearch', [TaskController::class, 'tasksBySearch']);

    Route::apiResource('/users', UserController::class);
});
