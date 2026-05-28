<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Services\CommissionService;
use App\Services\StockService;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        private CommissionService $commissionService,
        private StockService $stockService,
    ) {}

    /**
     * Create an order from cart items.
     */
    public function createFromCart(
        array $cartItemIds,
        array $addressData,
        string $courier,
        string $courierService,
        float $shippingCost,
        ?string $voucherCode = null,
        string $notes = ''
    ): Order {
        return DB::transaction(function () use (
            $cartItemIds, $addressData, $courier, $courierService,
            $shippingCost, $voucherCode, $notes
        ) {
            $items    = CartItem::with(['product.store', 'variant'])->findMany($cartItemIds);
            $buyer    = Auth::user();
            $storeId  = $items->first()->product->store_id;

            // Validate stock
            foreach ($items as $item) {
                if (!$this->stockService->isAvailable($item->product_id, $item->quantity, $item->variant_id)) {
                    throw new \Exception("Stok tidak mencukupi: {$item->product->name}");
                }
            }

            $subtotal = $items->sum(fn($i) => $i->quantity * $i->price_snapshot);
            $discount = 0;
            $voucher  = null;

            // Apply voucher
            if ($voucherCode) {
                $voucher = Voucher::active()->where('code', $voucherCode)->first();
                if ($voucher && $voucher->isValid()) {
                    $discount = $voucher->calculateDiscount($subtotal);
                }
            }

            $store      = $items->first()->product->store;
            $commission = $store->commission_rate
                ? round($subtotal * ($store->commission_rate / 100), 2)
                : round($subtotal * 0.05, 2);

            $total = max(0, $subtotal + $shippingCost - $discount);

            $order = Order::create([
                'order_number'     => 'ORD-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd'),
                'buyer_id'         => $buyer->id,
                'store_id'         => $storeId,
                'status'           => OrderStatus::Pending,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'discount'         => $discount,
                'commission'       => $commission,
                'tax'              => 0,
                'total'            => $total,
                'shipping_address' => $addressData,
                'notes'            => $notes,
            ]);

            // Create order items & deduct stock
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'               => $order->id,
                    'product_id'             => $item->product_id,
                    'product_name_snapshot'  => $item->product->name,
                    'price_snapshot'         => $item->price_snapshot,
                    'quantity'               => $item->quantity,
                    'subtotal'               => $item->quantity * $item->price_snapshot,
                ]);
            }

            // Record voucher usage
            if ($voucher && $discount > 0) {
                VoucherUsage::create([
                    'voucher_id'      => $voucher->id,
                    'user_id'         => $buyer->id,
                    'order_id'        => $order->id,
                    'discount_amount' => $discount,
                    'used_at'         => now(),
                ]);
                $voucher->increment('used_count');
            }

            // Initial status history
            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => OrderStatus::Pending,
                'note'       => 'Pesanan dibuat',
                'created_by' => $buyer->id,
                'created_at' => now(),
            ]);

            // Remove cart items
            CartItem::whereIn('id', $cartItemIds)->delete();

            return $order;
        });
    }

    public function cancel(Order $order, string $reason = ''): void
    {
        DB::transaction(function () use ($order, $reason) {
            // Restore stock
            foreach ($order->items as $item) {
                $this->stockService->restore($item->product_id, $item->quantity, $item->variant_id ?? null);
            }

            $order->update([
                'status'       => OrderStatus::Cancelled,
                'cancelled_at' => now(),
            ]);

            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => OrderStatus::Cancelled,
                'note'       => $reason ?: 'Dibatalkan',
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);
        });
    }

    public function markShipped(Order $order, string $courier, string $trackingNumber): void
    {
        $order->update(['status' => OrderStatus::Shipped]);

        $order->shipment()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'courier'          => $courier,
                'tracking_number'  => $trackingNumber,
                'status'           => 'shipped',
                'shipped_at'       => now(),
            ]
        );

        OrderStatusHistory::create([
            'order_id'   => $order->id,
            'status'     => OrderStatus::Shipped,
            'note'       => "Dikirim via {$courier}, resi: {$trackingNumber}",
            'created_by' => Auth::id(),
            'created_at' => now(),
        ]);
    }

    public function complete(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => OrderStatus::Completed]);

            // Credit seller wallet
            $wallet = $order->store->wallet;
            if ($wallet) {
                $sellerEarning = $order->subtotal - $order->commission;
                $wallet->credit(
                    $sellerEarning,
                    "Pendapatan order #{$order->order_number}",
                    $order->id,
                    Order::class
                );
            }

            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => OrderStatus::Completed,
                'note'       => 'Pesanan selesai',
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);
        });
    }
}
