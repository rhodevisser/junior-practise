<?php

namespace App\Services;

use Illuminate\Support\Collection;

class OrderCollectionService extends Collection
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function totalRevenue(Collection $orders): float
    {
        return $orders->sum('total');
    }

    public function byStatus(Collection $orders, string $status): Collection
    {

        return $orders->filter(function ($order) use ($status) {
            return $order['status'] === $status;
        });
    }

    public function topCostumers(Collection $orders, int $limit): Collection
    {
        return $orders->groupBy('customer_id')
            ->map(function ($customerOrders) {
                return [
                    'customer_id' => $customerOrders->first()['customer_id'],
                    'total_spend' => $customerOrders->sum('total'),
                ];
            })
            ->sortByDesc('total_spend')
            ->take($limit)
            ->collect();
    }

    public function formatNames(Collection $orders): Collection
    {
        return $orders->map(function ($order) {
            $order['customer_name'] = strtoupper($order['customer_name']);
            return $order;
        });
    }

    Public function uniqueStatuses(Collection $orders): Collection
    {
        return $orders->status->collect()->unique();
    }
}
