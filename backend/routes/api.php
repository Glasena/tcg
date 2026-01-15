<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TcgSetTypeController;
use App\Http\Controllers\TcgTypeController;
use Illuminate\Support\Facades\Route;

//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/tcg-types', [TcgTypeController::class, 'index']);
Route::get('/cards', [CardController::class, 'index']);
Route::get('/cards/{card}', [CardController::class, 'show']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Admin Routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/cards', [CardController::class, 'store']);
    Route::patch('/cards/{card}', [CardController::class, 'update']);
    Route::delete('/cards/{card}', [CardController::class, 'destroy']);
});