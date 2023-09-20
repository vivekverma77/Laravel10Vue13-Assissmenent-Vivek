<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\TaskController;
use App\Http\Controllers\Api\V2\CompleteTaskController;

Route::middleware('auth:sanctum')->prefix('v2')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
    Route::get('/tasks/tasksByStatus/{status}', [TaskController::class, 'tasksByStatus']);
    Route::post('/tasks/tasksBySearch', [TaskController::class, 'tasksBySearch']);
});
