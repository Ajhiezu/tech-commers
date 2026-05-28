<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status'           => OrderStatus::class,
        'shipping_address' => 'array',
        'subtotal'         => 'decimal:2',
        'shipping_cost'    => 'decimal:2',
        'discount'         => 'decimal:2',
        'commission'       => 'decimal:2',
        'tax'              => 'decimal:2',
        'total'            => 'decimal:2',
        'paid_at'          => 'datetime',
        'cancelled_at'     => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function voucher()
    {
        return $this->hasOneThrough(Voucher::class, VoucherUsage::class, 'order_id', 'id', 'id', 'voucher_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────
    public function scopeForBuyer($query, $userId)
    {
        return $query->where('buyer_id', $userId);
    }

    public function scopeForStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    public function scopePending($query)
    {
        return $query->where('status', OrderStatus::Pending);
    }

    public function scopePaid($query)
    {
        return $query->where('status', OrderStatus::Paid);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', OrderStatus::Completed);
    }

    // ─── Helpers ──────────────────────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [OrderStatus::Pending, OrderStatus::Paid]);
    }

    public function canBeReviewed(): bool
    {
        return $this->status === OrderStatus::Delivered;
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid()) . '-' . now()->format('Ymd');
            }
        });
    }
}
