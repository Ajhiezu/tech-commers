<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending  = 'pending';
    case Success  = 'success';
    case Failed   = 'failed';
    case Refunded = 'refunded';
    case Expired  = 'expired';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Menunggu Pembayaran',
            self::Success  => 'Berhasil',
            self::Failed   => 'Gagal',
            self::Refunded => 'Dikembalikan',
            self::Expired  => 'Kadaluarsa',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::Pending  => 'bg-yellow-100 text-yellow-800',
            self::Success  => 'bg-green-100 text-green-800',
            self::Failed   => 'bg-red-100 text-red-800',
            self::Refunded => 'bg-gray-100 text-gray-800',
            self::Expired  => 'bg-orange-100 text-orange-800',
        };
    }
}
