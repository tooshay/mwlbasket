<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/basket/items', [BasketController::class, 'addItem']);
    Route::delete('/basket/items/{item}', [BasketController::class, 'removeItem']);
    Route::post('/basket/checkout', [BasketController::class, 'checkout']);
    Route::get('/basket/removed-items', [BasketController::class, 'removedItems']);
});
