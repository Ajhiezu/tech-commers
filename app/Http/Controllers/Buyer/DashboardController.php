<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'pending_orders' => $user->orders()->pending()->count(),
            'completed_orders' => $user->orders()->completed()->count(),
            'wishlist_count' => $user->wishlists()->count(),
        ];
        
        $recentOrders = $user->orders()
            ->with(['store', 'items.product'])
            ->latest()
            ->take(3)
            ->get();
            
        $recentlyViewed = $user->recentlyViewed()
            ->with(['product.primaryImage', 'product.store'])
            ->latest('viewed_at')
            ->take(6)
            ->get();

        return view('buyer.dashboard', compact('stats', 'recentOrders', 'recentlyViewed'));
    }
}
