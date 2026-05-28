<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Auth::user()->orders()->with(['store', 'items.product', 'payment']);
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->paginate(10);
        $statuses = OrderStatus::cases();
        
        return view('buyer.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['store', 'items.product', 'statusHistories', 'payment']);
        return view('buyer.orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        $this->authorize('view', $order);
        
        if ($order->status !== OrderStatus::Delivered) {
            return back()->with('error', 'Pesanan belum terkirim');
        }

        app(\App\Services\OrderService::class)->complete($order);
        
        return back()->with('success', 'Pesanan diselesaikan. Jangan lupa berikan ulasan!');
    }
}
