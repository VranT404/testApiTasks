<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider, and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route to get user information for the authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// AuthController routes for user registration and login
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Routes for tasks and user management, protected by sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // Task routes
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/task/{taskId}', [TaskController::class, 'show']);
    Route::get('tasks/user_tasks', [TaskController::class, 'showUserTasks']);
    Route::post('tasks/task/create', [TaskController::class, 'create']);
    Route::put('tasks/update/{taskId}', [TaskController::class, 'update']);
    Route::delete('tasks/delete/{taskId}', [TaskController::class, 'destroy']);

    // User routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/user/{userId}', [UserController::class, 'show']);
    Route::post('users/user/create', [UserController::class, 'create']);
    Route::put('users/update/{userId}', [UserController::class, 'update']);
    Route::delete('users/delete/{userId}', [UserController::class, 'destroy']);
});
