<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('returns return items for an existing basket', function () {
    createAuthedUserWithFullBasket();

    $response = $this->json('GET', route('basket.get'));

    dd($response->json());
});
