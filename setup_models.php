<?php

$dir = __DIR__ . '/app/Models/';
$models = [
    'User.php' => <<<PHP
    protected \$guarded = ['id'];

    public function store()
    {
        return \$this->hasOne(Store::class);
    }

    public function orders()
    {
        return \$this->hasMany(Order::class, 'buyer_id');
    }

    public function reviews()
    {
        return \$this->hasMany(Review::class, 'buyer_id');
    }

    public function wishlists()
    {
        return \$this->hasMany(Wishlist::class);
    }

    public function recentlyViewed()
    {
        return \$this->hasMany(RecentlyViewed::class);
    }
PHP,
    'Store.php' => <<<PHP
    protected \$guarded = ['id'];

    public function user()
    {
        return \$this->belongsTo(User::class);
    }

    public function documents()
    {
        return \$this->hasMany(StoreDocument::class);
    }

    public function products()
    {
        return \$this->hasMany(Product::class);
    }

    public function orders()
    {
        return \$this->hasMany(Order::class);
    }

    public function wallet()
    {
        return \$this->hasOne(StoreWallet::class);
    }

    public function walletTransactions()
    {
        return \$this->hasMany(WalletTransaction::class);
    }

    public function withdrawals()
    {
        return \$this->hasMany(Withdrawal::class);
    }
PHP,
    'Category.php' => <<<PHP
    protected \$guarded = ['id'];

    public function parent()
    {
        return \$this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return \$this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return \$this->hasMany(Product::class);
    }
PHP,
    'Product.php' => <<<PHP
    protected \$guarded = ['id'];

    public function store()
    {
        return \$this->belongsTo(Store::class);
    }

    public function category()
    {
        return \$this->belongsTo(Category::class);
    }

    public function images()
    {
        return \$this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return \$this->hasMany(ProductVariant::class);
    }

    public function attributes()
    {
        return \$this->hasMany(ProductAttribute::class);
    }
    
    public function primaryImage()
    {
        return \$this->hasOne(ProductImage::class)->where('is_primary', true);
    }
    
    public function reviews()
    {
        return \$this->hasMany(Review::class);
    }
PHP,
    'ProductImage.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function product() { return \$this->belongsTo(Product::class); }
PHP,
    'ProductVariant.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function product() { return \$this->belongsTo(Product::class); }
PHP,
    'ProductAttribute.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function product() { return \$this->belongsTo(Product::class); }
PHP,
    'Cart.php' => <<<PHP
    protected \$guarded = ['id'];

    public function user() { return \$this->belongsTo(User::class); }
    public function items() { return \$this->hasMany(CartItem::class); }
PHP,
    'CartItem.php' => <<<PHP
    protected \$guarded = ['id'];

    public function cart() { return \$this->belongsTo(Cart::class); }
    public function product() { return \$this->belongsTo(Product::class); }
    public function variant() { return \$this->belongsTo(ProductVariant::class); }
PHP,
    'Order.php' => <<<PHP
    protected \$guarded = ['id'];
    protected \$casts = ['shipping_address' => 'array'];

    public function buyer() { return \$this->belongsTo(User::class, 'buyer_id'); }
    public function store() { return \$this->belongsTo(Store::class); }
    public function items() { return \$this->hasMany(OrderItem::class); }
    public function payment() { return \$this->hasOne(Payment::class); }
    public function shipment() { return \$this->hasOne(Shipment::class); }
    public function statusHistories() { return \$this->hasMany(OrderStatusHistory::class); }
PHP,
    'OrderItem.php' => <<<PHP
    protected \$guarded = ['id'];

    public function order() { return \$this->belongsTo(Order::class); }
    public function product() { return \$this->belongsTo(Product::class); }
    public function review() { return \$this->hasOne(Review::class); }
PHP,
    'Payment.php' => <<<PHP
    protected \$guarded = ['id'];
    protected \$casts = ['gateway_response' => 'array'];

    public function order() { return \$this->belongsTo(Order::class); }
PHP,
    'Shipment.php' => <<<PHP
    protected \$guarded = ['id'];

    public function order() { return \$this->belongsTo(Order::class); }
PHP,
    'Review.php' => <<<PHP
    protected \$guarded = ['id'];
    protected \$casts = ['images' => 'array'];

    public function orderItem() { return \$this->belongsTo(OrderItem::class); }
    public function product() { return \$this->belongsTo(Product::class); }
    public function buyer() { return \$this->belongsTo(User::class, 'buyer_id'); }
    public function store() { return \$this->belongsTo(Store::class); }
    public function helpfulVotes() { return \$this->hasMany(ReviewHelpful::class); }
PHP,
    'StoreWallet.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function store() { return \$this->belongsTo(Store::class); }
PHP,
    'Withdrawal.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function store() { return \$this->belongsTo(Store::class); }
PHP,
    'Voucher.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function store() { return \$this->belongsTo(Store::class); }
    public function usages() { return \$this->hasMany(VoucherUsage::class); }
PHP,
    'FlashSale.php' => <<<PHP
    protected \$guarded = ['id'];
    
    public function store() { return \$this->belongsTo(Store::class); }
    public function items() { return \$this->hasMany(FlashSaleItem::class); }
PHP,
    'SeoMeta.php' => <<<PHP
    protected \$guarded = ['id'];

    public function model() { return \$this->morphTo(); }
PHP
];

foreach ($models as $filename => $code) {
    if (file_exists($dir . $filename)) {
        $content = file_get_contents($dir . $filename);
        if ($filename !== 'User.php' && !str_contains($content, 'protected $guarded')) {
            $content = str_replace('    //', "$code", $content);
            file_put_contents($dir . $filename, $content);
        }
    }
}

// User model has its own structure
$user_path = $dir . 'User.php';
if (file_exists($user_path)) {
    $user_content = file_get_contents($user_path);
    if (!str_contains($user_content, 'public function store(')) {
        // remove fillable array to apply guarded
        $user_content = preg_replace('/protected \$fillable = \[.*?\];/s', "protected \$guarded = ['id'];", $user_content);
        $user_content = preg_replace('/protected function casts\(\).*?\{.*?\}/s', "\$0\n\n" . $models['User.php'], $user_content);
        
        if (!str_contains($user_content, 'HasRoles')) {
            $user_content = str_replace('use Illuminate\Foundation\Auth\User as Authenticatable;', "use Illuminate\Foundation\Auth\User as Authenticatable;\nuse Spatie\Permission\Traits\HasRoles;", $user_content);
            $user_content = str_replace('use Notifiable;', "use Notifiable;\n    use HasRoles;", $user_content);
        }
        
        file_put_contents($user_path, $user_content);
    }
}

$all_files = scandir($dir);
foreach ($all_files as $f) {
    if (str_ends_with($f, '.php') && !array_key_exists($f, $models)) {
        $pt = $dir . $f;
        $c = file_get_contents($pt);
        if (!str_contains($c, 'protected $guarded')) {
            $c = str_replace('    //', "    protected \$guarded = ['id'];", $c);
            file_put_contents($pt, $c);
        }
    }
}

echo "Model relationships initialized correctly.";
