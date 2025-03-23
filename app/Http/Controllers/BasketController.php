<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Http\Requests\AddItemRequest;
use Illuminate\Http\JsonResponse;

class BasketController extends Controller
{
    public function addItem(AddItemRequest $request): JsonResponse
    {
        $basket = auth()->user()->currentBasket();

        $basket->items()->create([
            'product_id' => $request->product_id,
            'status' => ItemStatus::ADDED->value,
        ]);

        return response()->json(['message' => 'Item added to basket']);
    }
}
