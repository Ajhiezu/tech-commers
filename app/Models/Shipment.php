<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'cost'          => 'decimal:2',
        'estimated_days' => 'integer',
        'shipped_at'    => 'datetime',
        'delivered_at'  => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Menunggu Pengiriman',
            'shipped'   => 'Dalam Pengiriman',
            'delivered' => 'Terkirim',
            default     => ucfirst($this->status),
        };
    }
}
