<?php

namespace App\Models;

use App\Enums\StoreStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status'       => StoreStatus::class,
        'is_featured'  => 'boolean',
        'verified_at'  => 'datetime',
        'commission_rate' => 'decimal:2',
        'balance'      => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('status', 'active');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function documents()
    {
        return $this->hasMany(StoreDocument::class);
    }

    public function wallet()
    {
        return $this->hasOne(StoreWallet::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function flashSales()
    {
        return $this->hasMany(FlashSale::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', StoreStatus::Active);
    }

    public function scopePending($query)
    {
        return $query->where('status', StoreStatus::Pending);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', StoreStatus::Active);
    }

    // ─── Helpers ──────────────────────────────────────────────────
    public function isActive(): bool
    {
        return $this->status === StoreStatus::Active;
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=EE4D2D&color=fff&size=128';
    }

    public function getBannerUrlAttribute(): string
    {
        if ($this->banner) {
            return asset('storage/' . $this->banner);
        }
        return 'https://placehold.co/1200x300/EE4D2D/white?text=' . urlencode($this->name);
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) $this->reviews()->avg('rating') ?? 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name) . '-' . Str::random(6);
            }
        });

        static::created(function ($store) {
            $store->wallet()->create([
                'balance'         => 0,
                'pending_balance' => 0,
                'total_earned'    => 0,
                'total_withdrawn' => 0,
            ]);
        });
    }
}
