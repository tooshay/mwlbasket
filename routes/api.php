<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/basket', [BasketController::class, 'get'])->name('basket.get');
    Route::post('/basket/items', [BasketController::class, 'addItem'])->name('basket.items.add');
    Route::delete('/basket/items/{item}', [BasketController::class, 'removeItem'])->name('basket.items.remove');
    Route::post('/basket/checkout', [BasketController::class, 'checkout'])->name('basket.checkout');
    Route::get('/basket/removed-items', [BasketController::class, 'removedItems'])->name('basket.items.removed');
});
