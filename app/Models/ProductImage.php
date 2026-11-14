<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_primary'  => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        return imageUrl($this->image_path);
    }
}
