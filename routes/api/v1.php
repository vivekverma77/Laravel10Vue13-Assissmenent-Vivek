<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\CompleteTaskController;
use App\Http\Controllers\Api\V1\UserController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
    Route::get('/tasks/tasksByStatus/{status}', [TaskController::class, 'tasksByStatus'])->name('tasks.byStatus');
    Route::post('/tasks/tasksBySearch', [TaskController::class, 'tasksBySearch'])->name('tasks.bySearch');

    Route::apiResource('/users', UserController::class);
});
