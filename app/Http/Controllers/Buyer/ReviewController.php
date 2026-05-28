<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;
    public function create(Order $order, OrderItem $item)
    {
        $this->authorize('review', $order);
        
        if ($item->order_id !== $order->id) abort(404);
        if ($item->review) return redirect()->route('buyer.orders.show', $order)->with('error', 'Produk ini sudah diulas');
        
        return view('buyer.reviews.create', compact('order', 'item'));
    }

    public function store(Request $request, Order $order, OrderItem $item)
    {
        $this->authorize('review', $order);
        if ($item->order_id !== $order->id) abort(404);
        if ($item->review) return back()->with('error', 'Produk ini sudah diulas');

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'images.*' => 'image|max:2048'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('reviews', 'public');
            }
        }

        Review::create([
            'order_item_id' => $item->id,
            'product_id' => $item->product_id,
            'buyer_id' => Auth::id(),
            'store_id' => $order->store_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => empty($images) ? null : $images,
            'is_verified_purchase' => true,
        ]);

        return redirect()->route('buyer.orders.show', $order)->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
