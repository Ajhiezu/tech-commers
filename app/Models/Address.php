<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->address_detail,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code,
        ]));
    }

    public function toShippingArray(): array
    {
        return [
            'recipient_name' => $this->recipient_name,
            'phone'          => $this->phone,
            'province'       => $this->province,
            'province_id'    => $this->province_id,
            'city'           => $this->city,
            'city_id'        => $this->city_id,
            'district'       => $this->district,
            'postal_code'    => $this->postal_code,
            'address_detail' => $this->address_detail,
            'full_address'   => $this->full_address,
        ];
    }
}
