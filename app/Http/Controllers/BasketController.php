<?php

namespace App\Http\Controllers;

use App\Actions\AddItemAction;
use App\Actions\CheckoutAction;
use App\Actions\RemoveItemAction;
use App\Http\Requests\ManipulateItemRequest;
use App\Repositories\ItemsRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Psy\Util\Json;

class BasketController extends Controller
{
    public function addItem(ManipulateItemRequest $request, AddItemAction $addItemAction): JsonResponse
    {
        try {
            $addItemAction->execute($request->validated());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Item added to basket']);
    }

    public function removeItem(ManipulateItemRequest $request, RemoveItemAction $removeItemAction): JsonResponse
    {
        try {
            $removeItemAction->execute($request->validated());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Item removed from basket']);
    }

    public function checkout(CheckoutAction $checkoutAction): JsonResponse
    {
        try {
            $checkoutAction->execute();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Checkout successful']);
    }

    public function removedItems(ItemsRepository $itemsRepository): JsonResponse
    {
        try {
            return response()->json($itemsRepository->findRemoved()->toJson());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
