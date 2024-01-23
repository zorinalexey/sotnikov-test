<?php

use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [UsersController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(static function () {
    Route::post('logout', [UsersController::class, 'logout'])->name('logout');

    Route::apiResource('tasks', TaskController::class);
});
