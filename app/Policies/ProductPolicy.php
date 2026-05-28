<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function update(User $user, Product $product): bool
    {
        return $user->store && $user->store->id === $product->store_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->store && $user->store->id === $product->store_id;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }
}
