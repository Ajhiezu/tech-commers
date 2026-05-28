<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-users', 'ban-users', 'verify-sellers',
            'manage-products', 'manage-orders', 'manage-reviews',
            'view-reports', 'export-reports',
            'manage-vouchers', 'manage-flash-sales',
            'process-withdrawals', 'manage-commissions',
            'view-audit-logs', 'manage-settings',
            'manage-categories', 'manage-payment-methods',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $seller     = Role::firstOrCreate(['name' => 'seller', 'guard_name' => 'web']);
        $buyer      = Role::firstOrCreate(['name' => 'buyer', 'guard_name' => 'web']);

        $superAdmin->syncPermissions(Permission::all());
        $seller->syncPermissions([]);
        $buyer->syncPermissions([]);

        $this->command->info('✅ Roles & Permissions seeded.');
    }
}
