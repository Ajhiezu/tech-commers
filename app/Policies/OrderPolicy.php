<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id
            || ($user->store && $user->store->id === $order->store_id)
            || $user->hasRole('super_admin');
    }

    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id
            && in_array($order->status, [OrderStatus::Pending, OrderStatus::Paid]);
    }

    public function updateStatus(User $user, Order $order): bool
    {
        return ($user->store && $user->store->id === $order->store_id)
            || $user->hasRole('super_admin');
    }

    public function review(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id
            && $order->status === OrderStatus::Delivered;
    }
}
