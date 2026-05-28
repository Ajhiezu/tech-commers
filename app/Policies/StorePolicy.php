<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    public function update(User $user, Store $store): bool
    {
        return $user->id === $store->user_id || $user->hasRole('super_admin');
    }

    public function manage(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }
}
