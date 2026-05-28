<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status'            => PaymentStatus::class,
        'amount'            => 'decimal:2',
        'gateway_response'  => 'array',
        'paid_at'           => 'datetime',
        'expired_at'        => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function isPaid(): bool
    {
        return $this->status === PaymentStatus::Success;
    }

    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at->isPast() && $this->status === PaymentStatus::Pending;
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
