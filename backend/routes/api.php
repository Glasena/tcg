<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\TcgTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/tcg-types', [TcgTypeController::class, 'index']);
Route::post('/cards', [CardController::class, 'store']);
Route::get('/cards', [CardController::class, 'show']);
Route::patch('/cards/{card}', [CardController::class, 'update']);
Route::delete('/cards/{card}', [CardController::class, 'destroy']);