<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $with = ['primaryImage', 'images'];

    protected $casts = [
        'price'          => 'decimal:2',
        'compare_price'  => 'decimal:2',
        'stock'          => 'integer',
        'weight'         => 'integer',
        'status'         => ProductStatus::class,
        'is_featured'    => 'boolean',
        'total_sold'     => 'integer',
        'average_rating' => 'decimal:2',
        'views_count'    => 'integer',
    ];

    // ─── Relationships ────────────────────────────────────────────
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true)->latest();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_active', true);
    }

    public function allReviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function recentlyViewed()
    {
        return $this->hasMany(RecentlyViewed::class);
    }

    public function flashSaleItems()
    {
        return $this->hasMany(FlashSaleItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', ProductStatus::Active);
    }

    public function scopePublished($query)
    {
        return $query->active()->whereHas('store', fn($q) => $q->active());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->active();
    }

    public function scopeTrending($query)
    {
        return $query->active()->orderByDesc('total_sold');
    }

    public function scopeNew($query)
    {
        return $query->active()->latest();
    }

    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // ─── Helpers ──────────────────────────────────────────────────
    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->primaryImage;
        if ($primary) {
            return $primary->url;
        }
        if ($this->images->count()) {
            return $this->images->first()->url;
        }
        return imageUrl(null);
    }

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function hasDiscount(): bool
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0 && $this->status === ProductStatus::Active;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedComparePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->compare_price, 0, ',', '.');
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(8);
            }
        });
    }
}
