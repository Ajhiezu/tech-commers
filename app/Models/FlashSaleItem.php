<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'stock_limit'         => 'integer',
        'sold_count'          => 'integer',
    ];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSalePrice(): float
    {
        return $this->product->price * (1 - $this->discount_percentage / 100);
    }

    public function getRemainingStockAttribute(): int
    {
        return max(0, $this->stock_limit - $this->sold_count);
    }

    public function isSoldOut(): bool
    {
        return $this->remaining_stock <= 0;
    }
}
