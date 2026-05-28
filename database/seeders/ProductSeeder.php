<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Enums\ProductStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();
        $categories = Category::whereNotNull('parent_id')->get();

        $products = [
            ['name' => 'iPhone 15 Pro Max 256GB', 'price' => 21999000, 'compare' => 23999000, 'weight' => 221],
            ['name' => 'Samsung Galaxy S24 Ultra', 'price' => 18499000, 'compare' => 20000000, 'weight' => 232],
            ['name' => 'Laptop ASUS ROG Strix G16', 'price' => 23500000, 'compare' => 26000000, 'weight' => 2300],
            ['name' => 'MacBook Air M3 13 inch', 'price' => 19999000, 'compare' => null, 'weight' => 1240],
            ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 5499000, 'compare' => 6000000, 'weight' => 250],
            ['name' => 'Canon EOS R50 Kit', 'price' => 12500000, 'compare' => 14000000, 'weight' => 375],
            ['name' => 'Kemeja Flanel Premium Pria', 'price' => 185000, 'compare' => 250000, 'weight' => 300],
            ['name' => 'Dress Batik Wanita Modern', 'price' => 275000, 'compare' => 350000, 'weight' => 250],
            ['name' => 'Celana Jogger Pria Casual', 'price' => 159000, 'compare' => 200000, 'weight' => 400],
            ['name' => 'Tas Tote Bag Kulit Premium', 'price' => 349000, 'compare' => 450000, 'weight' => 600],
            ['name' => 'Sepatu Sneakers Pria Original', 'price' => 489000, 'compare' => 650000, 'weight' => 800],
            ['name' => 'Wardah Sunscreen SPF 50+', 'price' => 45000, 'compare' => 65000, 'weight' => 80],
            ['name' => 'Emina BB Cream Natural', 'price' => 35000, 'compare' => 50000, 'weight' => 60],
            ['name' => 'Somethinc AHA BHA Toner', 'price' => 89000, 'compare' => 120000, 'weight' => 150],
            ['name' => 'Implora Rose Lip Serum', 'price' => 29000, 'compare' => 45000, 'weight' => 30],
            ['name' => 'Atomic Habits James Clear', 'price' => 99000, 'compare' => 120000, 'weight' => 350],
            ['name' => 'Laskar Pelangi Andrea Hirata', 'price' => 69000, 'compare' => 85000, 'weight' => 300],
            ['name' => 'Buku Matematika SMA Kelas 12', 'price' => 75000, 'compare' => null, 'weight' => 400],
            ['name' => 'Panci Anti Lengket Teflon 24cm', 'price' => 125000, 'compare' => 180000, 'weight' => 800],
            ['name' => 'Rice Cooker Miyako 1.8L', 'price' => 199000, 'compare' => 250000, 'weight' => 2000],
            ['name' => 'Blender Philips 2L 600W', 'price' => 379000, 'compare' => 450000, 'weight' => 1800],
            ['name' => 'Set Pisau Dapur Stainless 5pcs', 'price' => 149000, 'compare' => 200000, 'weight' => 600],
            ['name' => 'Vitamin C Enervon 500mg 30 tablet', 'price' => 45000, 'compare' => 65000, 'weight' => 100],
            ['name' => 'Masker KF94 Korea 20pcs', 'price' => 35000, 'compare' => 50000, 'weight' => 150],
            ['name' => 'Treadmill Lipat Elektrik', 'price' => 3850000, 'compare' => 4500000, 'weight' => 25000],
            ['name' => 'Sepatu Running Nike Air Zoom', 'price' => 1299000, 'compare' => 1599000, 'weight' => 320],
            ['name' => 'Celana Training Dri-Fit', 'price' => 249000, 'compare' => 350000, 'weight' => 250],
            ['name' => 'Indomie Goreng Spesial 40pcs', 'price' => 85000, 'compare' => null, 'weight' => 1600],
            ['name' => 'Keripik Singkong Pedas 500g', 'price' => 25000, 'compare' => 35000, 'weight' => 500],
            ['name' => 'Earbuds TWS Bluetooth 5.3', 'price' => 189000, 'compare' => 250000, 'weight' => 50],
            ['name' => 'Power Bank 20000mAh Fast Charge', 'price' => 245000, 'compare' => 320000, 'weight' => 380],
            ['name' => 'Smart Watch Fitness Tracker', 'price' => 399000, 'compare' => 550000, 'weight' => 45],
            ['name' => 'Dompet Kulit Pria Slim', 'price' => 129000, 'compare' => 180000, 'weight' => 100],
            ['name' => 'Jam Tangan Casio Classic', 'price' => 750000, 'compare' => 900000, 'weight' => 120],
            ['name' => 'Serum Vitamin C Niacinamide 30ml', 'price' => 75000, 'compare' => 100000, 'weight' => 80],
            ['name' => 'Foundation Liquid SPF 30', 'price' => 89000, 'compare' => 120000, 'weight' => 100],
            ['name' => 'Aroma Diffuser Ultrasonic 500ml', 'price' => 189000, 'compare' => 250000, 'weight' => 450],
            ['name' => 'Vacuum Cleaner Wireless Portable', 'price' => 459000, 'compare' => 600000, 'weight' => 1200],
            ['name' => 'Cermin Dinding Aesthetic 60x40cm', 'price' => 275000, 'compare' => 350000, 'weight' => 2000],
            ['name' => 'Rich Dad Poor Dad Kiyosaki', 'price' => 89000, 'compare' => 110000, 'weight' => 280],
            ['name' => 'Tensi Meter Digital Omron', 'price' => 385000, 'compare' => 450000, 'weight' => 350],
            ['name' => 'Kopi Arabika Toraja 250g', 'price' => 75000, 'compare' => null, 'weight' => 250],
            ['name' => 'Helm Fullface KYT Striker', 'price' => 699000, 'compare' => 850000, 'weight' => 1200],
            ['name' => 'Car Charger USB-C 65W', 'price' => 125000, 'compare' => 180000, 'weight' => 80],
            ['name' => 'Karpet Mobil Custom 5D', 'price' => 350000, 'compare' => 450000, 'weight' => 3000],
            ['name' => 'Parfum Pria Hugo Boss 100ml', 'price' => 450000, 'compare' => 600000, 'weight' => 150],
            ['name' => 'Body Mist Victoria Secret 250ml', 'price' => 165000, 'compare' => 220000, 'weight' => 280],
            ['name' => 'Conditioner Pantene Pro-V 380ml', 'price' => 42000, 'compare' => 60000, 'weight' => 380],
            ['name' => 'Stabilo Pen 68 24 Colors', 'price' => 89000, 'compare' => 120000, 'weight' => 200],
            ['name' => 'Meja Belajar Lipat Portable', 'price' => 249000, 'compare' => 320000, 'weight' => 3500],
        ];

        foreach ($products as $index => $p) {
            $store = $stores[$index % $stores->count()];
            $category = $categories[$index % $categories->count()];

            $product = Product::create([
                'store_id'       => $store->id,
                'category_id'    => $category->id,
                'name'           => $p['name'],
                'slug'           => Str::slug($p['name']) . '-' . Str::random(6),
                'description'    => "Produk {$p['name']} berkualitas tinggi dengan harga terbaik. Tersedia dalam berbagai pilihan. Pengiriman cepat ke seluruh Indonesia.",
                'price'          => $p['price'],
                'compare_price'  => $p['compare'],
                'stock'          => rand(10, 200),
                'weight'         => $p['weight'],
                'sku'            => 'SKU-' . strtoupper(Str::random(6)),
                'status'         => ProductStatus::Active,
                'is_featured'    => $index < 8,
                'total_sold'     => rand(0, 1500),
                'average_rating' => round(rand(35, 50) / 10, 1),
                'views_count'    => rand(100, 10000),
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/placeholder.jpg',
                'is_primary' => true,
                'sort_order' => 0,
                'alt_text'   => $product->name,
            ]);
        }

        $this->command->info('✅ Products seeded (50 products).');
    }
}
