<?php

namespace App\Models;

use App\Enums\WithdrawalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status'       => WithdrawalStatus::class,
        'amount'       => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', WithdrawalStatus::Pending);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function isPending(): bool
    {
        return $this->status === WithdrawalStatus::Pending;
    }
}
