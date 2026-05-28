<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'icon' => null, 'children' => [
                'Handphone & Tablet', 'Laptop & Komputer', 'Kamera', 'Aksesoris Elektronik',
            ]],
            ['name' => 'Fashion Wanita', 'icon' => null, 'children' => [
                'Baju Wanita', 'Celana Wanita', 'Dress', 'Tas Wanita',
            ]],
            ['name' => 'Fashion Pria', 'icon' => null, 'children' => [
                'Baju Pria', 'Celana Pria', 'Sepatu Pria', 'Aksesoris Pria',
            ]],
            ['name' => 'Kecantikan', 'icon' => null, 'children' => [
                'Skincare', 'Makeup', 'Parfum', 'Perawatan Rambut',
            ]],
            ['name' => 'Makanan & Minuman', 'icon' => null, 'children' => [
                'Makanan Ringan', 'Minuman', 'Bumbu & Rempah', 'Makanan Instan',
            ]],
            ['name' => 'Rumah & Dapur', 'icon' => null, 'children' => [
                'Perabot Rumah', 'Perlengkapan Dapur', 'Dekorasi', 'Alat Kebersihan',
            ]],
            ['name' => 'Olahraga', 'icon' => null, 'children' => [
                'Sepatu Olahraga', 'Pakaian Olahraga', 'Peralatan Gym', 'Outdoor',
            ]],
            ['name' => 'Buku & Alat Tulis', 'icon' => null, 'children' => [
                'Buku Pelajaran', 'Novel', 'Alat Tulis', 'Majalah',
            ]],
            ['name' => 'Kesehatan', 'icon' => null, 'children' => [
                'Vitamin & Suplemen', 'Alat Kesehatan', 'Obat-obatan', 'Perawatan Bayi',
            ]],
            ['name' => 'Otomotif', 'icon' => null, 'children' => [
                'Aksesoris Motor', 'Aksesoris Mobil', 'Spare Part', 'Perawatan Kendaraan',
            ]],
        ];

        $sort = 0;
        foreach ($categories as $cat) {
            $parent = Category::create([
                'name'       => $cat['name'],
                'slug'       => \Illuminate\Support\Str::slug($cat['name']),
                'is_active'  => true,
                'sort_order' => ++$sort,
            ]);

            foreach ($cat['children'] as $childName) {
                Category::create([
                    'parent_id'  => $parent->id,
                    'name'       => $childName,
                    'slug'       => \Illuminate\Support\Str::slug($childName),
                    'is_active'  => true,
                    'sort_order' => 0,
                ]);
            }
        }

        $this->command->info('✅ Categories seeded (10 + subcategories).');
    }
}
