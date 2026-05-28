<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyers  = User::role('buyer')->get();
        $stores  = Store::with('products')->get();
        $statuses = OrderStatus::cases();

        for ($i = 0; $i < 100; $i++) {
            $buyer  = $buyers->random();
            $store  = $stores->random();
            $products = $store->products->take(rand(1, 3));
            if ($products->isEmpty()) continue;

            $status = $statuses[array_rand($statuses)];
            $subtotal = 0;
            $itemsData = [];

            foreach ($products as $product) {
                $qty = rand(1, 3);
                $price = $product->price;
                $sub = $price * $qty;
                $subtotal += $sub;
                $itemsData[] = compact('product', 'qty', 'price', 'sub');
            }

            $shippingCost = rand(9000, 35000);
            $discount     = 0;
            $commission   = round($subtotal * ($store->commission_rate / 100), 2);
            $tax          = 0;
            $total        = $subtotal + $shippingCost - $discount;

            $isPaid = !in_array($status, [OrderStatus::Pending, OrderStatus::Cancelled]);
            $createdAt = now()->subDays(rand(1, 90));

            $order = Order::create([
                'order_number'    => 'ORD-' . strtoupper(Str::random(8)) . '-' . $createdAt->format('Ymd'),
                'buyer_id'        => $buyer->id,
                'store_id'        => $store->id,
                'status'          => $status,
                'subtotal'        => $subtotal,
                'shipping_cost'   => $shippingCost,
                'discount'        => $discount,
                'commission'      => $commission,
                'tax'             => $tax,
                'total'           => $total,
                'shipping_address' => json_encode([
                    'recipient_name' => $buyer->name,
                    'phone'          => $buyer->phone ?? '081234567890',
                    'city'           => 'Jakarta',
                    'province'       => 'DKI Jakarta',
                    'address_detail' => 'Jl. Contoh No. ' . rand(1, 100),
                    'postal_code'    => '12345',
                ]),
                'paid_at'         => $isPaid ? $createdAt->addHours(rand(1, 3)) : null,
                'cancelled_at'    => $status === OrderStatus::Cancelled ? $createdAt->addHours(24) : null,
                'created_at'      => $createdAt,
                'updated_at'      => $createdAt,
            ]);

            foreach ($itemsData as $item) {
                OrderItem::create([
                    'order_id'            => $order->id,
                    'product_id'          => $item['product']->id,
                    'product_name_snapshot' => $item['product']->name,
                    'price_snapshot'      => $item['price'],
                    'quantity'            => $item['qty'],
                    'subtotal'            => $item['sub'],
                ]);
            }

            // Payment
            Payment::create([
                'order_id'          => $order->id,
                'payment_number'    => 'PAY-' . strtoupper(Str::random(10)),
                'method'            => 'bank_transfer',
                'gateway'           => 'midtrans',
                'amount'            => $total,
                'status'            => $isPaid ? PaymentStatus::Success : PaymentStatus::Pending,
                'paid_at'           => $isPaid ? $order->paid_at : null,
                'expired_at'        => !$isPaid ? $createdAt->addDays(1) : null,
            ]);

            // Status history
            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => OrderStatus::Pending,
                'note'       => 'Order dibuat',
                'created_at' => $createdAt,
            ]);
        }

        $this->command->info('✅ Orders seeded (100 orders).');
    }
}
