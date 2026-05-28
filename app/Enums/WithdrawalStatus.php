<?php

namespace App\Enums;

enum WithdrawalStatus: string
{
    case Pending   = 'pending';
    case Approved  = 'approved';
    case Rejected  = 'rejected';
    case Processed = 'processed';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Menunggu',
            self::Approved  => 'Disetujui',
            self::Rejected  => 'Ditolak',
            self::Processed => 'Diproses',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::Pending   => 'bg-yellow-100 text-yellow-800',
            self::Approved  => 'bg-blue-100 text-blue-800',
            self::Rejected  => 'bg-red-100 text-red-800',
            self::Processed => 'bg-green-100 text-green-800',
        };
    }
}
