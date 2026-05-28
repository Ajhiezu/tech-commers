<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use App\Enums\StoreStatus;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'name'        => 'TechZone Official',
                'description' => 'Toko elektronik terpercaya dengan produk original dan bergaransi resmi.',
                'province'    => 'DKI Jakarta',
                'city'        => 'Jakarta Pusat',
                'commission_rate' => 5.00,
            ],
            [
                'name'        => 'Fashion ID',
                'description' => 'Koleksi fashion terkini untuk pria dan wanita dengan harga terjangkau.',
                'province'    => 'Jawa Barat',
                'city'        => 'Bandung',
                'commission_rate' => 8.00,
            ],
            [
                'name'        => 'Glow Beauty',
                'description' => 'Produk kecantikan & skincare terbaik dari brand lokal dan internasional.',
                'province'    => 'DKI Jakarta',
                'city'        => 'Jakarta Selatan',
                'commission_rate' => 7.00,
            ],
            [
                'name'        => 'Buku Pintar',
                'description' => 'Jual beli buku berkualitas — pelajaran, novel, self-help dan lebih banyak lagi.',
                'province'    => 'Jawa Tengah',
                'city'        => 'Semarang',
                'commission_rate' => 6.00,
            ],
            [
                'name'        => 'Dapur Cantik',
                'description' => 'Peralatan dapur & rumah tangga lengkap untuk rumah impian Anda.',
                'province'    => 'Jawa Timur',
                'city'        => 'Surabaya',
                'commission_rate' => 7.50,
            ],
        ];

        $sellers = User::role('seller')->get();

        foreach ($stores as $index => $storeData) {
            $seller = $sellers[$index] ?? $sellers->first();

            Store::create([
                'user_id'         => $seller->id,
                'name'            => $storeData['name'],
                'slug'            => \Illuminate\Support\Str::slug($storeData['name']) . '-' . \Illuminate\Support\Str::random(4),
                'description'     => $storeData['description'],
                'status'          => StoreStatus::Active,
                'commission_rate' => $storeData['commission_rate'],
                'balance'         => rand(500000, 10000000),
                'address'         => $storeData['city'] . ', ' . $storeData['province'],
                'is_featured'     => $index < 3,
                'verified_at'     => now(),
            ]);
        }

        $this->command->info('✅ Stores seeded (5 active stores).');
    }
}
