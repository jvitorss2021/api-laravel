<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/users', [UserController::class, 'index']);

    Route::apiResource('/courses', CourseController::class);
});