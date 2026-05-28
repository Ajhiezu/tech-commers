<?php

namespace Database\Seeders;

use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherAndFlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Platform-wide vouchers
        Voucher::create([
            'store_id'    => null,
            'code'        => 'WELCOME50',
            'type'        => 'fixed',
            'value'       => 50000,
            'min_purchase'=> 100000,
            'max_discount'=> null,
            'usage_limit' => 1000,
            'used_count'  => 0,
            'is_active'   => true,
            'starts_at'   => now()->subDay(),
            'expires_at'  => now()->addMonths(3),
        ]);

        Voucher::create([
            'store_id'    => null,
            'code'        => 'DISKON10',
            'type'        => 'percentage',
            'value'       => 10,
            'min_purchase'=> 200000,
            'max_discount'=> 75000,
            'usage_limit' => 500,
            'used_count'  => 0,
            'is_active'   => true,
            'starts_at'   => now()->subDay(),
            'expires_at'  => now()->addMonths(2),
        ]);

        Voucher::create([
            'store_id'    => null,
            'code'        => 'GRATIS20',
            'type'        => 'fixed',
            'value'       => 20000,
            'min_purchase'=> 150000,
            'max_discount'=> null,
            'usage_limit' => null,
            'used_count'  => 0,
            'is_active'   => true,
            'starts_at'   => now(),
            'expires_at'  => now()->addMonth(),
        ]);

        // Store vouchers
        $stores = Store::all();
        foreach ($stores as $store) {
            Voucher::create([
                'store_id'    => $store->id,
                'code'        => 'TOKO' . strtoupper(\Illuminate\Support\Str::random(4)),
                'type'        => 'percentage',
                'value'       => rand(5, 15),
                'min_purchase'=> 50000,
                'max_discount'=> 50000,
                'usage_limit' => 100,
                'used_count'  => 0,
                'is_active'   => true,
                'starts_at'   => now()->subDay(),
                'expires_at'  => now()->addMonths(2),
            ]);
        }

        // Flash Sale — active now
        $flashSale = FlashSale::create([
            'store_id'   => null,
            'name'       => 'Flash Sale Harbolnas',
            'starts_at'  => now()->subHour(),
            'ends_at'    => now()->addHours(23),
            'is_active'  => true,
        ]);

        $products = Product::inRandomOrder()->take(8)->get();
        foreach ($products as $product) {
            FlashSaleItem::create([
                'flash_sale_id'      => $flashSale->id,
                'product_id'         => $product->id,
                'discount_percentage'=> rand(20, 60),
                'stock_limit'        => rand(10, 50),
                'sold_count'         => rand(0, 5),
            ]);
        }

        $this->command->info('✅ Vouchers & Flash Sales seeded.');
    }
}
