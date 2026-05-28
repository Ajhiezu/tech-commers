<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Active      = 'active';
    case Inactive    = 'inactive';
    case OutOfStock  = 'out_of_stock';

    public function label(): string
    {
        return match($this) {
            self::Active     => 'Aktif',
            self::Inactive   => 'Nonaktif',
            self::OutOfStock => 'Habis',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::Active     => 'bg-green-100 text-green-800',
            self::Inactive   => 'bg-gray-100 text-gray-800',
            self::OutOfStock => 'bg-red-100 text-red-800',
        };
    }
}
