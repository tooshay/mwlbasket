<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::prefix('basket')->group(static function (): void {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [BasketController::class, 'get'])->name('basket.get');
        Route::post('/items', [BasketController::class, 'addItem'])->name('basket.items.add');
        Route::delete('/items/{item_id}', [BasketController::class, 'removeItem'])->name('basket.items.remove');
        Route::post('/checkout', [BasketController::class, 'checkout'])->name('basket.checkout');
        Route::get('/removed-items', [BasketController::class, 'removedItems'])->name('basket.items.removed');
    });
});
