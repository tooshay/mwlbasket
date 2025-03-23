<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/basket/add', [BasketController::class, 'add']);
    Route::post('/basket/remove', [BasketController::class, 'remove']);
    Route::get('/removed-items', [BasketController::class, 'removedItems']);
});
