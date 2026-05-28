<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Seller     = 'seller';
    case Buyer      = 'buyer';

    public function label(): string
    {
        return match($this) {
            self::SuperAdmin => 'Super Admin',
            self::Seller     => 'Penjual',
            self::Buyer      => 'Pembeli',
        };
    }
}
