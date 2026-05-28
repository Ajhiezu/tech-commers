<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => null, 'expires_at' => null]
            );
        }

        $sessionId = Session::getId();
        return Cart::firstOrCreate(
            ['session_id' => $sessionId, 'user_id' => null],
            ['expires_at' => now()->addDays(7)]
        );
    }

    public function addItem(int $productId, int $quantity = 1, ?int $variantId = null): CartItem
    {
        $product = Product::findOrFail($productId);
        $cart    = $this->getCart();
        $price   = $product->price;

        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price  += $variant->price_adjustment;
        }

        $existing = $cart->items()
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            if ($newQty > $product->stock) {
                $newQty = $product->stock;
            }
            $existing->update([
                'quantity'       => $newQty,
                'price_snapshot' => $price,
            ]);
            return $existing;
        }

        return $cart->items()->create([
            'product_id'     => $productId,
            'variant_id'     => $variantId,
            'quantity'       => min($quantity, $product->stock),
            'price_snapshot' => $price,
        ]);
    }

    public function updateItem(int $cartItemId, int $quantity): CartItem
    {
        $item = CartItem::findOrFail($cartItemId);
        $this->authorize($item);

        if ($quantity <= 0) {
            $item->delete();
            return $item;
        }

        $maxStock = $item->product->stock ?? $quantity;
        $item->update(['quantity' => min($quantity, $maxStock)]);
        return $item;
    }

    public function removeItem(int $cartItemId): void
    {
        $item = CartItem::findOrFail($cartItemId);
        $this->authorize($item);
        $item->delete();
    }

    public function clear(): void
    {
        $this->getCart()->items()->delete();
    }

    public function getItemCount(): int
    {
        return $this->getCart()->items()->sum('quantity');
    }

    public function getTotal(): float
    {
        $cart = $this->getCart();
        return $cart->items->sum(fn($item) => $item->quantity * $item->price_snapshot);
    }

    public function mergeGuestCart(int $userId): void
    {
        $sessionId  = Session::getId();
        $guestCart  = Cart::where('session_id', $sessionId)->where('user_id', null)->first();
        if (!$guestCart) return;

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($guestCart->items as $item) {
            $existing = $userCart->items()
                ->where('product_id', $item->product_id)
                ->where('variant_id', $item->variant_id)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item->quantity);
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        $guestCart->delete();
    }

    private function authorize(CartItem $item): void
    {
        $cart = $this->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }
    }
}
