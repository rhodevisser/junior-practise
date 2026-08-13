<?php

use App\Services\OrderCollectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('calculates total revenue', function () {
    $orders = collect([
        ['total' => 100, 'status' => 'paid'],
        ['total' => 200, 'status' => 'paid'],
        ['total' => 50,  'status' => 'refunded'],
    ]);

    expect(app(OrderCollectionService::class)->totalRevenue($orders))->toBe(350.0);
});

it('filters by status', function () {
    $orders = collect([
        ['status' => 'paid', 'total' => 100],
        ['status' => 'refunded', 'total' => 50],
        ['status' => 'paid', 'total' => 200],
    ]);

    $paid = app(OrderCollectionService::class)->byStatus($orders, 'paid');
    expect($paid)->toHaveCount(2);
});

it('partitions even and odd totals correctly', function () {
    $data = collect([1, 2, 3, 4, 5]);
    [$even, $odd] = $data->partition(fn ($v) => $v % 2 === 0);
    expect([$even->sum(), $odd->sum()])->toEqual([6, 9]);
});

it('does not mutate the original collection with map', function () {
    $original = collect([1, 2, 3]);
    $original->map(fn ($n) => $n * 2);
    expect($original->toArray())->toEqual([1, 2, 3]);
});
