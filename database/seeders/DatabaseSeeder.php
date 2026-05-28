<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            PlatformSettingSeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            ReviewSeeder::class,
            VoucherAndFlashSaleSeeder::class,
        ]);

        $this->command->info('🎉 All seeders completed successfully!');
    }
}
