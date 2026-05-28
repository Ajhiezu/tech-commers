<?php

namespace App\Services;

use App\Models\CommissionRule;
use App\Models\Order;
use App\Models\Product;

class CommissionService
{
    public function calculate(Order $order): float
    {
        $subtotal = $order->subtotal;
        $store    = $order->store;

        // Per-store override
        if ($store->commission_rate) {
            return round($subtotal * ($store->commission_rate / 100), 2);
        }

        // Category-specific rule
        $categoryIds = $order->items->pluck('product.category_id')->unique();
        $rule = CommissionRule::whereIn('category_id', $categoryIds)
            ->orderByDesc('effective_from')
            ->first();

        // Global fallback
        if (!$rule) {
            $rule = CommissionRule::whereNull('category_id')
                ->orderByDesc('effective_from')
                ->first();
        }

        if ($rule) {
            return round($rule->calculateCommission($subtotal), 2);
        }

        // Hard fallback: 5%
        return round($subtotal * 0.05, 2);
    }

    public function getRate(int $categoryId = null): float
    {
        if ($categoryId) {
            $rule = CommissionRule::where('category_id', $categoryId)->first();
            if ($rule) return $rule->percentage;
        }

        $global = CommissionRule::whereNull('category_id')->first();
        return $global ? $global->percentage : 5.0;
    }
}
