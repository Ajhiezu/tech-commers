<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'is_banned'         => 'boolean',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'buyer_id');
    }

    public function recentlyViewed()
    {
        return $this->hasMany(RecentlyViewed::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_banned', false);
    }

    public function scopeSellers($query)
    {
        return $query->role('seller');
    }

    public function scopeBuyers($query)
    {
        return $query->role('buyer');
    }

    // ─── Helpers ──────────────────────────────────────────────────
    public function isSeller(): bool
    {
        return $this->hasRole('seller');
    }

    public function isBuyer(): bool
    {
        return $this->hasRole('buyer');
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isBanned(): bool
    {
        return (bool) ($this->is_banned ?? false);
    }

    public function getAvatarUrlAttribute(): string
    {
        return imageUrl($this->avatar, 'avatar');
    }
}
