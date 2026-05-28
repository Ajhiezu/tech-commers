<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active'  => 'boolean',
        'fee_amount' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function calculateFee(float $amount): float
    {
        if ($this->fee_type === 'percentage') {
            return $amount * ($this->fee_amount / 100);
        }
        return $this->fee_amount ?? 0;
    }
}
