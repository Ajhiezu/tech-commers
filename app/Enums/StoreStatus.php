<?php

namespace App\Enums;

enum StoreStatus: string
{
    case Pending   = 'pending';
    case Active    = 'active';
    case Suspended = 'suspended';
    case Rejected  = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Menunggu Persetujuan',
            self::Active    => 'Aktif',
            self::Suspended => 'Ditangguhkan',
            self::Rejected  => 'Ditolak',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::Pending   => 'bg-yellow-100 text-yellow-800',
            self::Active    => 'bg-green-100 text-green-800',
            self::Suspended => 'bg-orange-100 text-orange-800',
            self::Rejected  => 'bg-red-100 text-red-800',
        };
    }
}
