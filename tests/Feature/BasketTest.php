<?php

use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('returns return items for an existing basket', function () {
    createAuthedUserWithFullBasket();

    $response = $this->json('GET', route('basket.get'));

    $response->assertStatus(200);
});

it('adds an item to the authenticated user basket', function () {
    createAuthedUserWithFullBasket();
    $product = Product::first();

    // Act
    $response = postJson('/items', [
        'product_id' => $product->id,
    ]);

    // Assert
    $response->assertCreated();

    $response->assertJson(fn (AssertableJson $json) =>
    $json->where('product_id', $product->id)
        ->where('status', 'ADDED')
        ->hasAll(['id', 'basket_id', 'product_id', 'status', 'created_at', 'updated_at'])
    );

    expect(Item::count())->toBe(1);
    expect(Item::first())->product_id->toBe($product->id);
});
