<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active'  => 'boolean',
        'starts_at'  => 'datetime',
        'ends_at'    => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class)->withDefault();
    }

    public function items()
    {
        return $this->hasMany(FlashSaleItem::class)->with('product');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function isActive(): bool
    {
        return $this->is_active
            && $this->starts_at->isPast()
            && $this->ends_at->isFuture();
    }

    public function getRemainingSecondsAttribute(): int
    {
        return max(0, now()->diffInSeconds($this->ends_at, false));
    }
}
