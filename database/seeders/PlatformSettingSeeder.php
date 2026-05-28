<?php

namespace Database\Seeders;

use App\Models\PlatformSetting;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PlatformSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'platform_name',        'value' => 'TechCommers',     'type' => 'string',  'description' => 'Nama platform'],
            ['key' => 'commission_rate',       'value' => '5',               'type' => 'decimal', 'description' => 'Komisi default platform (%)'],
            ['key' => 'tax_rate',              'value' => '0',               'type' => 'decimal', 'description' => 'PPN (%)'],
            ['key' => 'min_withdrawal',        'value' => '50000',           'type' => 'integer', 'description' => 'Minimum penarikan saldo (Rp)'],
            ['key' => 'withdrawal_auto_days',  'value' => '7',               'type' => 'integer', 'description' => 'Hari otomatis cairkan saldo setelah order selesai'],
            ['key' => 'free_ongkir_min',       'value' => '0',               'type' => 'integer', 'description' => 'Minimum belanja gratis ongkir (0 = tidak aktif)'],
            ['key' => 'flash_sale_enabled',    'value' => '1',               'type' => 'boolean', 'description' => 'Aktifkan flash sale'],
            ['key' => 'voucher_enabled',       'value' => '1',               'type' => 'boolean', 'description' => 'Aktifkan voucher'],
            ['key' => 'chat_enabled',          'value' => '1',               'type' => 'boolean', 'description' => 'Aktifkan chat penjual-pembeli'],
            ['key' => 'maintenance_mode',      'value' => '0',               'type' => 'boolean', 'description' => 'Mode maintenance'],
            ['key' => 'footer_text',           'value' => '© 2025 TechCommers. All rights reserved.', 'type' => 'string', 'description' => 'Teks footer'],
            ['key' => 'support_email',         'value' => 'support@techcommers.id', 'type' => 'string', 'description' => 'Email support'],
            ['key' => 'support_phone',         'value' => '021-12345678',    'type' => 'string',  'description' => 'Telepon support'],
            ['key' => 'midtrans_enabled',      'value' => '0',               'type' => 'boolean', 'description' => 'Aktifkan Midtrans'],
            ['key' => 'dummy_payment_enabled', 'value' => '1',               'type' => 'boolean', 'description' => 'Aktifkan dummy payment (dev)'],
        ];

        foreach ($settings as $setting) {
            PlatformSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // Payment Methods
        $methods = [
            ['name' => 'Transfer Bank',     'code' => 'bank_transfer',  'fee_type' => 'fixed',      'fee_amount' => 0,    'is_active' => true],
            ['name' => 'GoPay',             'code' => 'gopay',          'fee_type' => 'percentage', 'fee_amount' => 0,    'is_active' => true],
            ['name' => 'OVO',               'code' => 'ovo',            'fee_type' => 'percentage', 'fee_amount' => 0,    'is_active' => true],
            ['name' => 'DANA',              'code' => 'dana',           'fee_type' => 'percentage', 'fee_amount' => 0,    'is_active' => true],
            ['name' => 'Kartu Kredit/Debit','code' => 'credit_card',    'fee_type' => 'percentage', 'fee_amount' => 2.9,  'is_active' => true],
            ['name' => 'Bayar di Tempat',   'code' => 'cod',            'fee_type' => 'fixed',      'fee_amount' => 5000, 'is_active' => false],
            ['name' => 'BCA Virtual Account','code' => 'bca_va',        'fee_type' => 'fixed',      'fee_amount' => 4000, 'is_active' => true],
            ['name' => 'Mandiri Virtual Account','code' => 'mandiri_va','fee_type' => 'fixed',      'fee_amount' => 4000, 'is_active' => true],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(['code' => $method['code']], $method);
        }

        $this->command->info('✅ Platform settings & payment methods seeded.');
    }
}
