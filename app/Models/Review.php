<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'rating'              => 'integer',
        'images'              => 'array',
        'is_verified_purchase' => 'boolean',
        'is_active'           => 'boolean',
        'likes_count'         => 'integer',
        'seller_replied_at'   => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function helpfuls()
    {
        return $this->hasMany(ReviewHelpful::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    public function getImageUrlsAttribute(): array
    {
        if (empty($this->images)) return [];
        return array_map(fn($img) => asset('storage/' . $img), $this->images);
    }

    public function hasSellerReply(): bool
    {
        return !empty($this->seller_reply);
    }
}
