<?php

$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

$replacements = [
    'users_table' => <<<PHP
            \$table->id();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->string('phone')->nullable();
            \$table->string('avatar')->nullable();
            \$table->boolean('is_active')->default(true);
            \$table->rememberToken();
            \$table->timestamps();
            \$table->softDeletes();
PHP,
    'stores_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->string('logo')->nullable();
            \$table->string('banner')->nullable();
            \$table->text('description')->nullable();
            \$table->string('status')->default('pending'); // Enum: StoreStatus
            \$table->decimal('commission_rate', 5, 2)->nullable(); // override global
            \$table->decimal('balance', 15, 2)->default(0);
            \$table->text('address')->nullable();
            \$table->string('province_id')->nullable();
            \$table->string('city_id')->nullable();
            \$table->boolean('is_featured')->default(false);
            \$table->timestamp('verified_at')->nullable();
            \$table->text('rejected_reason')->nullable();
            \$table->timestamps();
            \$table->softDeletes();
PHP,
    'store_documents_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->string('type'); // ktp, npwp, etc
            \$table->string('file_path');
            \$table->timestamp('verified_at')->nullable();
            \$table->timestamps();
PHP,
    'categories_table' => <<<PHP
            \$table->id();
            \$table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->string('icon')->nullable();
            \$table->string('image')->nullable();
            \$table->boolean('is_active')->default(true);
            \$table->integer('sort_order')->default(0);
            \$table->timestamps();
PHP,
    'products_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->longText('description')->nullable();
            \$table->decimal('price', 15, 2);
            \$table->decimal('compare_price', 15, 2)->nullable();
            \$table->integer('stock')->default(0);
            \$table->integer('weight')->default(0); // in grams
            \$table->string('sku')->nullable();
            \$table->string('status')->default('active'); // Enum: ProductStatus
            \$table->boolean('is_featured')->default(false);
            \$table->integer('total_sold')->default(0);
            \$table->decimal('average_rating', 3, 2)->default(0);
            \$table->integer('views_count')->default(0);
            \$table->string('meta_title')->nullable();
            \$table->text('meta_description')->nullable();
            \$table->timestamps();
            \$table->softDeletes();
            
            \$table->index(['store_id', 'status', 'created_at']);
            \$table->index(['category_id', 'status', 'average_rating']);
            // FULLTEXT added in statement later
PHP,
    'product_images_table' => <<<PHP
            \$table->id();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->string('image_path');
            \$table->string('alt_text')->nullable();
            \$table->integer('sort_order')->default(0);
            \$table->boolean('is_primary')->default(false);
            \$table->timestamps();
PHP,
    'product_variants_table' => <<<PHP
            \$table->id();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->string('name'); // e.g. "Red - XL"
            \$table->decimal('price_adjustment', 15, 2)->default(0);
            \$table->integer('stock')->default(0);
            \$table->timestamps();
PHP,
    'product_attributes_table' => <<<PHP
            \$table->id();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->string('attribute_name');
            \$table->string('attribute_value');
            \$table->timestamps();
PHP,
    'carts_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            \$table->string('session_id')->nullable();
            \$table->timestamp('expires_at')->nullable();
            \$table->timestamps();
            
            \$table->index(['session_id', 'expires_at']);
            \$table->index('user_id');
PHP,
    'cart_items_table' => <<<PHP
            \$table->id();
            \$table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            \$table->integer('quantity');
            \$table->decimal('price_snapshot', 15, 2)->nullable();
            \$table->timestamps();
PHP,
    'orders_table' => <<<PHP
            \$table->id();
            \$table->string('order_number')->unique();
            \$table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->string('status')->default('pending'); // Enum: OrderStatus
            \$table->decimal('subtotal', 15, 2);
            \$table->decimal('shipping_cost', 15, 2)->default(0);
            \$table->decimal('discount', 15, 2)->default(0);
            \$table->decimal('commission', 15, 2)->default(0);
            \$table->decimal('tax', 15, 2)->default(0);
            \$table->decimal('total', 15, 2);
            \$table->json('shipping_address');
            \$table->text('notes')->nullable();
            \$table->timestamp('paid_at')->nullable();
            \$table->timestamp('cancelled_at')->nullable();
            \$table->timestamps();
            \$table->softDeletes();
            
            \$table->index(['buyer_id', 'status', 'created_at']);
            \$table->index(['store_id', 'status', 'created_at']);
PHP,
    'order_items_table' => <<<PHP
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            \$table->string('product_name_snapshot');
            \$table->decimal('price_snapshot', 15, 2);
            \$table->integer('quantity');
            \$table->decimal('subtotal', 15, 2);
            \$table->timestamps();
PHP,
    'order_status_histories_table' => <<<PHP
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->string('status');
            \$table->text('note')->nullable();
            \$table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            \$table->timestamps();
PHP,
    'payments_table' => <<<PHP
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->string('payment_number')->unique();
            \$table->string('method')->nullable();
            \$table->string('gateway')->default('midtrans');
            \$table->decimal('amount', 15, 2);
            \$table->string('status')->default('pending'); // Enum: PaymentStatus
            \$table->string('gateway_transaction_id')->nullable();
            \$table->json('gateway_response')->nullable();
            \$table->string('snap_token')->nullable();
            \$table->timestamp('paid_at')->nullable();
            \$table->timestamp('expired_at')->nullable();
            \$table->timestamps();
PHP,
    'payment_methods_table' => <<<PHP
            \$table->id();
            \$table->string('name');
            \$table->string('code')->unique();
            \$table->string('icon')->nullable();
            \$table->string('fee_type')->default('fixed'); // fixed, percentage
            \$table->decimal('fee_amount', 15, 2)->default(0);
            \$table->boolean('is_active')->default(true);
            \$table->timestamps();
PHP,
    'shipments_table' => <<<PHP
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->string('courier')->nullable();
            \$table->string('service')->nullable();
            \$table->string('tracking_number')->nullable();
            \$table->decimal('cost', 15, 2)->default(0);
            \$table->string('estimated_days')->nullable();
            \$table->string('status')->default('pending');
            \$table->timestamp('shipped_at')->nullable();
            \$table->timestamp('delivered_at')->nullable();
            \$table->timestamps();
PHP,
    'shipping_rates_table' => <<<PHP
            \$table->id();
            \$table->string('origin_province_id');
            \$table->string('destination_province_id');
            \$table->string('courier');
            \$table->string('service');
            \$table->decimal('cost', 15, 2);
            \$table->string('etd')->nullable();
            \$table->timestamps();
PHP,
    'reviews_table' => <<<PHP
            \$table->id();
            \$table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->tinyInteger('rating'); // 1-5
            \$table->text('comment')->nullable();
            \$table->json('images')->nullable();
            \$table->boolean('is_verified_purchase')->default(true);
            \$table->integer('likes_count')->default(0);
            \$table->text('seller_reply')->nullable();
            \$table->timestamp('seller_replied_at')->nullable();
            \$table->boolean('is_active')->default(true);
            \$table->timestamps();
            
            \$table->index(['product_id', 'is_active']);
PHP,
    'review_helpfuls_table' => <<<PHP
            \$table->id();
            \$table->foreignId('review_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->timestamps();
PHP,
    'store_wallets_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->decimal('balance', 15, 2)->default(0);
            \$table->decimal('pending_balance', 15, 2)->default(0);
            \$table->decimal('total_earned', 15, 2)->default(0);
            \$table->decimal('total_withdrawn', 15, 2)->default(0);
            \$table->timestamps();
PHP,
    'wallet_transactions_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->string('type'); // credit, debit
            \$table->decimal('amount', 15, 2);
            \$table->string('description')->nullable();
            \$table->string('reference_id')->nullable();
            \$table->string('reference_type')->nullable();
            \$table->decimal('balance_after', 15, 2)->default(0);
            \$table->timestamps();
PHP,
    'withdrawals_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->constrained()->cascadeOnDelete();
            \$table->decimal('amount', 15, 2);
            \$table->string('bank_name');
            \$table->string('bank_account');
            \$table->string('bank_holder');
            \$table->string('status')->default('pending'); // Enum: WithdrawalStatus
            \$table->text('admin_note')->nullable();
            \$table->timestamp('processed_at')->nullable();
            \$table->timestamps();
PHP,
    'vouchers_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->nullable()->constrained()->cascadeOnDelete(); // null = platform voucher
            \$table->string('code')->unique();
            \$table->string('type'); // percentage, fixed
            \$table->decimal('value', 15, 2);
            \$table->decimal('min_purchase', 15, 2)->default(0);
            \$table->decimal('max_discount', 15, 2)->nullable();
            \$table->integer('usage_limit')->nullable();
            \$table->integer('used_count')->default(0);
            \$table->timestamp('starts_at')->nullable();
            \$table->timestamp('expires_at')->nullable();
            \$table->boolean('is_active')->default(true);
            \$table->timestamps();
PHP,
    'voucher_usages_table' => <<<PHP
            \$table->id();
            \$table->foreignId('voucher_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->decimal('discount_amount', 15, 2);
            \$table->timestamps();
PHP,
    'flash_sales_table' => <<<PHP
            \$table->id();
            \$table->foreignId('store_id')->nullable()->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->timestamp('starts_at');
            \$table->timestamp('ends_at');
            \$table->boolean('is_active')->default(true);
            \$table->timestamps();
PHP,
    'flash_sale_items_table' => <<<PHP
            \$table->id();
            \$table->foreignId('flash_sale_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->decimal('discount_percentage', 5, 2);
            \$table->integer('stock_limit');
            \$table->integer('sold_count')->default(0);
            \$table->timestamps();
PHP,
    'wishlists_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->timestamps();
PHP,
    'recently_viewed_table' => <<<PHP
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->timestamp('viewed_at');
            \$table->timestamps();
PHP,
    'seo_metas_table' => <<<PHP
            \$table->id();
            \$table->morphs('model');
            \$table->string('title')->nullable();
            \$table->text('description')->nullable();
            \$table->string('keywords')->nullable();
            \$table->string('og_image')->nullable();
            \$table->timestamps();
PHP,
    'platform_settings_table' => <<<PHP
            \$table->id();
            \$table->string('key')->unique();
            \$table->text('value')->nullable();
            \$table->string('type')->default('string');
            \$table->string('description')->nullable();
            \$table->timestamps();
PHP,
    'commission_rules_table' => <<<PHP
            \$table->id();
            \$table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete(); // null = global
            \$table->decimal('percentage', 5, 2)->default(0);
            \$table->decimal('fixed_amount', 15, 2)->default(0);
            \$table->timestamp('effective_from');
            \$table->timestamps();
PHP,
];

foreach ($files as $file) {
    if (str_ends_with($file, '.php')) {
        $path = $dir . $file;
        $content = file_get_contents($path);
        
        foreach ($replacements as $key => $fields) {
            if (str_contains($file, $key)) {
                // If it's the users table modify default columns instead
                if ($key === 'users_table') {
                    $content = preg_replace('/\$table->id\(\);.*\$table->timestamps\(\);/s', $fields, $content);
                } else {
                    $content = preg_replace('/\$table->id\(\);.*\$table->timestamps\(\);/s', $fields, $content);
                }
                
                // Add DB statement for FULLTEXT if needed
                if ($key === 'products_table') {
                    $content = str_replace('Schema::create(\'products\', function (Blueprint $table) {', 
                    "Schema::create('products', function (Blueprint \$table) {", $content);
                    
                    // Add raw statement after create
                    $content = preg_replace("/\}\);\s+}/", "});\n        DB::statement('ALTER TABLE products ADD FULLTEXT INDEX fulltext_index (name, description)');\n    }", $content);
                    
                    // Add DB facade
                    $content = str_replace("use Illuminate\Support\Facades\Schema;", "use Illuminate\Support\Facades\Schema;\nuse Illuminate\Support\Facades\DB;", $content);
                }
                
                file_put_contents($path, $content);
                break;
            }
        }
    }
}

echo "Migrations updated based on spec.";

