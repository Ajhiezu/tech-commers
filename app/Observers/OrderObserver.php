<?php

namespace App\Observers;

use App\Models\Order;
use App\Enums\OrderStatus;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            $order->statusHistories()->create([
                'status'     => $order->status,
                'note'       => 'Status diperbarui',
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
        }
    }
}
