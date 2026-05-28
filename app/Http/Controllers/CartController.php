<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        try {
            $this->cartService->addItem($request->product_id, $request->quantity, $request->variant_id);
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_count' => $this->cartService->getItemCount(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);
        
        try {
            $this->cartService->updateItem($itemId, $request->quantity);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function remove($itemId)
    {
        try {
            $this->cartService->removeItem($itemId);
            return back()->with('success', 'Produk dihapus dari keranjang');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
