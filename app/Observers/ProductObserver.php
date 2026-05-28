<?php

namespace App\Observers;

use App\Models\Product;
use App\Enums\ProductStatus;

class ProductObserver
{
    public function updated(Product $product): void
    {
        if ($product->stock <= 0 && $product->status === ProductStatus::Active) {
            $product->updateQuietly(['status' => ProductStatus::OutOfStock]);
        }

        if ($product->stock > 0 && $product->status === ProductStatus::OutOfStock) {
            $product->updateQuietly(['status' => ProductStatus::Active]);
        }
    }
}
