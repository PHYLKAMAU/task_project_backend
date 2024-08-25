<?php

use App\Http\Controllers\ModifyTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Prefixing API routes with 'v1'
Route::prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/update/{id}', [ModifyTaskController::class, 'updateTask']);
    Route::patch('tasks/complete/{id}', [ModifyTaskController::class, 'markComplete']);
    Route::delete('tasks/delete/{id}', [ModifyTaskController::class, 'deleteComplete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
