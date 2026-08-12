<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use function Laravel\Prompts\error;

class ProductController extends Controller
{
    public function featured()
    {
        $ip = request()->ip();
        Cache::add($ip, 0, 60 * 60);
        Cache::increment($ip, 1);
        if (Cache::get($ip) > 100) {
            return response()->json(['message' => 'Too many requests'], 429);
        }

        $products = Cache::remember('featured_products', 30 * 60, function () {
            return Product::where('is_featured', true)->get();
            });

        return response()->json($products);

    }
}
