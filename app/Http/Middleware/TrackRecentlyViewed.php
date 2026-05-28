<?php

namespace App\Http\Middleware;

use App\Models\RecentlyViewed;
use Closure;
use Illuminate\Http\Request;

class TrackRecentlyViewed
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        // Track on product detail pages
        if ($request->user() && $request->route('slug') && $request->routeIs('products.show')) {
            $product = \App\Models\Product::where('slug', $request->route('slug'))->first();

            if ($product) {
                RecentlyViewed::updateOrCreate(
                    ['user_id' => $request->user()->id, 'product_id' => $product->id],
                    ['viewed_at' => now()]
                );

                // Keep only last 20
                $ids = RecentlyViewed::where('user_id', $request->user()->id)
                    ->orderByDesc('viewed_at')
                    ->skip(20)
                    ->take(PHP_INT_MAX)
                    ->pluck('id');

                if ($ids->isNotEmpty()) {
                    RecentlyViewed::whereIn('id', $ids)->delete();
                }
            }
        }

        return $response;
    }
}
