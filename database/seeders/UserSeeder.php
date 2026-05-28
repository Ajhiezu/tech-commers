<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@techcommers.id'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('password'),
                'phone'             => '081234567890',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super_admin');

        // Sellers
        $sellers = [
            ['name' => 'Toko Elektronik Jaya',    'email' => 'seller1@techcommers.id'],
            ['name' => 'Fashion Store Indonesia',  'email' => 'seller2@techcommers.id'],
            ['name' => 'Kosmetik Cantik',          'email' => 'seller3@techcommers.id'],
            ['name' => 'Buku & Alat Tulis',        'email' => 'seller4@techcommers.id'],
            ['name' => 'Dapur & Rumah Tangga',     'email' => 'seller5@techcommers.id'],
        ];

        foreach ($sellers as $s) {
            $user = User::firstOrCreate(
                ['email' => $s['email']],
                [
                    'name'              => $s['name'],
                    'password'          => Hash::make('password'),
                    'phone'             => '08' . rand(100000000, 999999999),
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole('seller');
        }

        // Buyers
        for ($i = 1; $i <= 20; $i++) {
            $user = User::firstOrCreate(
                ['email' => "buyer{$i}@techcommers.id"],
                [
                    'name'              => "Pembeli {$i}",
                    'password'          => Hash::make('password'),
                    'phone'             => '08' . rand(100000000, 999999999),
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole('buyer');
        }

        $this->command->info('✅ Users seeded (1 admin, 5 sellers, 20 buyers).');
    }
}
