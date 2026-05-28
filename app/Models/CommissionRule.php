<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionRule extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'percentage'     => 'decimal:2',
        'fixed_amount'   => 'decimal:2',
        'effective_from' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault(['name' => 'Global']);
    }

    public function isGlobal(): bool
    {
        return is_null($this->category_id);
    }

    public function calculateCommission(float $amount): float
    {
        $commission = 0;
        if ($this->percentage) {
            $commission += $amount * ($this->percentage / 100);
        }
        if ($this->fixed_amount) {
            $commission += $this->fixed_amount;
        }
        return $commission;
    }
}
