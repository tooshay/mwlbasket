<?php

use App\Enums\ItemStatus;
use App\Models\Basket;
use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

it('returns return items for an existing basket', function () {
    createAuthedUserWithFullBasket();

    $response = $this->json('GET', route('basket.get'));

    $response->assertOk();
});

it('adds an item to the user basket', function () {
    $user = User::first();
    Basket::factory()->create(['user_id' => $user->id]);
    $product = Product::first();

    $response = $this
        ->actingAs($user)
        ->json('POST', route('basket.items.add'), [
            'product_id' => $product->id,
        ]);

    $response->assertCreated();

    $response
        ->assertJson(fn (AssertableJson $json) => $json
            ->where('status', ItemStatus::ADDED->value)
            ->hasAll(['id', 'basket_id', 'status', 'quantity', 'added', 'product'])
        );

    expect(Item::count())->toBe(1)
        ->and(Item::first())->product_id->toBe($product->id);
});

it('checks out the basket and updates all item statuses to purchased', function () {
    $user = User::factory()->create();
    $product1 = Product::first();
    $product2 = Product::find(2);

    $basket = Basket::factory()
        ->for($user)
        ->create();

    $item1 = $basket->items()->create([
        'product_id' => $product1->id,
        'status' => ItemStatus::ADDED->value,
    ]);

    $item2 = $basket->items()->create([
        'product_id' => $product2->id,
        'status' => ItemStatus::ADDED->value,
    ]);

    $response = $this
        ->actingAs($user)
        ->json('POST', route('basket.checkout'));

    $response->assertOk();
    $response->assertJsonFragment([
        'message' => "Checkout successful for basket {$basket->id}",
    ]);

    $this->assertSame(
        ItemStatus::PURCHASED->value,
        $item1->fresh()->status
    );

    $this->assertSame(
        ItemStatus::PURCHASED->value,
        $item2->fresh()->status
    );
});

it('removes an item from a user\'s basket', function () {
    $user = User::factory()->create();
    $product = Product::first();
    $basket = Basket::factory()->for($user)->create();

    $item = $basket->items()->create([
        'product_id' => $product->id,
        'status' => ItemStatus::ADDED->value,
    ]);

    $response = $this
        ->actingAs($user)
        ->json('DELETE', route('basket.items.remove', ['item_id' => $item->id]), ['item_id' => $item->id]);

    $response->assertOk();

    $response->assertJsonPath('status', ItemStatus::REMOVED->value);
    $response->assertJsonPath('product.id', $product->id);

    expect($item->fresh()->status)->toBe(ItemStatus::REMOVED->value);
});

it('returns only removed items', function () {
    $user = User::factory()->create();
    $basket = Basket::factory()->for($user)->create();
    $product1 = Product::first();
    $product2 = Product::find(2);

    // Add one removed and one added item
    $removedItem = $basket->items()->create([
        'product_id' => $product1->id,
        'status' => ItemStatus::REMOVED->value,
    ]);

    $addedItem = $basket->items()->create([
        'product_id' => $product2->id,
        'status' => ItemStatus::ADDED->value,
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson(route('basket.items.removed'));

    $response->assertOk();

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has(0, fn ($json) => $json
            ->where('id', $removedItem->id)
            ->where('status', ItemStatus::REMOVED->value)
            ->where('product.id', $product1->id)
            ->where('product.name', $product1->name)
            ->etc()
        )
    );
});

it('returns validation errors as JSON when adding invalid item', function () {
    $user = User::factory()->create();
    Basket::factory()->create(['user_id' => $user->id]);

    // Send a non-numeric product_id
    $response = $this
        ->actingAs($user)
        ->json('POST', route('basket.items.add'), [
            'product_id' => 'not-a-number',
        ]);

    // Should return 422 with validation errors in JSON format
    $response->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('error')
            ->has('messages.product_id')
        );
});

it('returns validation errors as JSON when removing invalid item', function () {
    $user = User::factory()->create();
    Basket::factory()->for($user)->create();

    $response = $this
        ->actingAs($user)
        ->json('DELETE', route('basket.items.remove', ['item_id' => 'not-a-number']));

    $response->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('error')
            ->has('messages.item_id')
        );
});
