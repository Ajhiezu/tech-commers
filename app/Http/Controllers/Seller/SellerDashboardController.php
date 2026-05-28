<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        
        $stats = [
            'total_products' => $store->products()->count(),
            'active_products' => $store->activeProducts()->count(),
            'total_orders' => $store->orders()->count(),
            'pending_orders' => $store->orders()->where('status', OrderStatus::Pending)->count(),
            'total_earnings' => $store->wallet->total_earned ?? 0,
            'balance' => $store->wallet->balance ?? 0,
        ];

        $recentOrders = $store->orders()
            ->with(['buyer', 'items'])
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('stats', 'recentOrders'));
    }
}
