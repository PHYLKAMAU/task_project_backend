<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Prefixing API routes with 'v1'
Route::prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
