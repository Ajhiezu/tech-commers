<?php

$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

// Remove existing timestamp prefixes from tech_commers tables
// Map them to precise order
$order = [
    'users_table',
    'cache_table',
    'jobs_table',
    'permission_tables',
    'stores_table',
    'store_documents_table',
    'categories_table',
    'products_table',
    'product_images_table',
    'product_variants_table',
    'product_attributes_table',
    'carts_table',
    'cart_items_table',
    'orders_table',
    'order_items_table',
    'order_status_histories_table',
    'payments_table',
    'payment_methods_table',
    'shipments_table',
    'shipping_rates_table',
    'reviews_table',
    'review_helpfuls_table',
    'store_wallets_table',
    'wallet_transactions_table',
    'withdrawals_table',
    'vouchers_table',
    'voucher_usages_table',
    'flash_sales_table',
    'flash_sale_items_table',
    'wishlists_table',
    'recently_viewed_table',
    'seo_metas_table',
    'platform_settings_table',
    'commission_rules_table'
];

$timestamp_counter = 100000;

foreach ($order as $table_name) {
    // Find the file that contains $table_name
    foreach ($files as $file) {
        if (str_ends_with($file, $table_name . '.php')) {
            $path = $dir . $file;
            $new_timestamp = '2026_04_20_' . $timestamp_counter . '_';
            
            // remove prefix
            $pattern = '/^\d{4}_\d{2}_\d{2}_\d{6}_([a-zA-Z0-9_]+)$/i';
            $basename = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/i', '', $file);
            // also catch 0001_01_01_000000_
            $basename = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/i', '', $basename);
            
            $new_path = $dir . $new_timestamp . $basename;
            if ($path != $new_path) {
                rename($path, $new_path);
            }
            
            $timestamp_counter++;
            break;
        }
    }
}
echo "Migration files reordered.\n";
