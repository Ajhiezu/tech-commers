<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Enums\OrderStatus;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            'Barang sesuai deskripsi, pengiriman cepat. Sangat puas!',
            'Kualitas bagus, harga terjangkau. Recommended!',
            'Produk original, packaging aman. Penjual responsif.',
            'Sesuai foto, bahan berkualitas. Pasti beli lagi.',
            'Pengiriman cepat, produk memuaskan. Terima kasih!',
            'Barang sampai dengan aman. Kualitas sesuai ekspektasi.',
            'Produk bagus, tapi pengiriman agak lama.',
            'Overall bagus, worth it harganya!',
            'Mantap jiwa! Kualitas premium harga terjangkau.',
            'Seller fast response, barang original. 5 bintang!',
        ];

        $deliveredOrders = Order::where('status', OrderStatus::Delivered)
            ->with(['items.product', 'buyer'])
            ->get();

        foreach ($deliveredOrders as $order) {
            foreach ($order->items as $item) {
                if (!$item->product) continue;
                if (rand(0, 1) === 0) continue; // 50% chance of review

                Review::create([
                    'order_item_id'        => $item->id,
                    'product_id'           => $item->product_id,
                    'buyer_id'             => $order->buyer_id,
                    'store_id'             => $order->store_id,
                    'rating'               => rand(3, 5),
                    'comment'              => $comments[array_rand($comments)],
                    'images'               => null,
                    'is_verified_purchase' => true,
                    'likes_count'          => rand(0, 50),
                    'is_active'            => true,
                ]);
            }
        }

        $this->command->info('✅ Reviews seeded.');
    }
}
