<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Enums\ProductStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    public function deduct(int $productId, int $quantity, ?int $variantId = null): bool
    {
        return DB::transaction(function () use ($productId, $quantity, $variantId) {
            $product = Product::lockForUpdate()->findOrFail($productId);

            if ($variantId) {
                $variant = ProductVariant::lockForUpdate()->findOrFail($variantId);
                if ($variant->stock < $quantity) {
                    throw new \Exception("Stok varian tidak mencukupi untuk produk: {$product->name}");
                }
                $variant->decrement('stock', $quantity);
            } else {
                if ($product->stock < $quantity) {
                    throw new \Exception("Stok tidak mencukupi untuk produk: {$product->name}");
                }
                $product->decrement('stock', $quantity);
                $product->increment('total_sold', $quantity);
            }

            // Check if out of stock
            if ($product->fresh()->stock <= 0) {
                $product->update(['status' => ProductStatus::OutOfStock]);
            }

            return true;
        });
    }

    public function restore(int $productId, int $quantity, ?int $variantId = null): void
    {
        DB::transaction(function () use ($productId, $quantity, $variantId) {
            $product = Product::lockForUpdate()->findOrFail($productId);

            if ($variantId) {
                ProductVariant::lockForUpdate()
                    ->findOrFail($variantId)
                    ->increment('stock', $quantity);
            } else {
                $product->increment('stock', $quantity);
                $product->decrement('total_sold', $quantity);
            }

            // Re-activate if was out of stock
            if ($product->status === ProductStatus::OutOfStock && $product->fresh()->stock > 0) {
                $product->update(['status' => ProductStatus::Active]);
            }
        });
    }

    public function isAvailable(int $productId, int $quantity, ?int $variantId = null): bool
    {
        $product = Product::find($productId);
        if (!$product || $product->status !== ProductStatus::Active) return false;

        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            return $variant && $variant->stock >= $quantity;
        }

        return $product->stock >= $quantity;
    }
}
