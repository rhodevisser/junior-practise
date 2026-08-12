<?php

use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns featured products from cache on second call', function () {
    Product::factory()->count(5)->create(['is_featured' => true]);

    $this->getJson('/api/products/featured')->assertOk();

    $queryCount = 0;
    DB::listen(fn () => $queryCount++);

    $this->getJson('/api/products/featured')->assertOk();

    // Second request should use cache - no DB queries
    expect($queryCount)->toBe(0);
});

it('invalidates the cache when a product is updated', function () {
    Product::factory()->count(3)->create(['is_featured' => true]);
    $this->getJson('/api/products/featured'); // prime cache

    Product::first()->update(['name' => 'Updated Name']);

    // Cache should be invalidated - next request queries DB
    $this->assertTrue(!Cache::has('featured_products'));
});
