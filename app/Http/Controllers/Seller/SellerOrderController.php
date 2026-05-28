<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellerOrderController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        
        $query = $store->orders()->with(['buyer', 'items']);
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->paginate(15);
        $statuses = OrderStatus::cases();
        
        return view('seller.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['buyer', 'items.product', 'statusHistories', 'shipping_address']);
        
        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);
        
        $request->validate([
            'status' => 'required|string',
            'tracking_number' => 'nullable|string|required_if:status,' . OrderStatus::Shipped->value,
            'courier' => 'nullable|string|required_if:status,' . OrderStatus::Shipped->value,
        ]);

        $orderService = app(\App\Services\OrderService::class);

        try {
            if ($request->status === OrderStatus::Shipped->value) {
                $orderService->markShipped($order, $request->courier, $request->tracking_number);
            } else if ($request->status === OrderStatus::Cancelled->value) {
                $orderService->cancel($order, $request->cancel_reason ?? 'Dibatalkan oleh penjual');
            } else {
                $order->update(['status' => $request->status]);
                $order->statusHistories()->create([
                    'status' => OrderStatus::from($request->status),
                    'note' => 'Status diperbarui penjual',
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                ]);
            }
            
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }
}
