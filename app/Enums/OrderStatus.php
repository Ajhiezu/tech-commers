<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending    = 'pending';
    case Paid       = 'paid';
    case Processing = 'processing';
    case Shipped    = 'shipped';
    case Delivered  = 'delivered';
    case Completed  = 'completed';
    case Cancelled  = 'cancelled';
    case Refunded   = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::Pending    => 'Menunggu Pembayaran',
            self::Paid       => 'Sudah Dibayar',
            self::Processing => 'Diproses Penjual',
            self::Shipped    => 'Dalam Pengiriman',
            self::Delivered  => 'Terkirim',
            self::Completed  => 'Selesai',
            self::Cancelled  => 'Dibatalkan',
            self::Refunded   => 'Dikembalikan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending    => 'yellow',
            self::Paid       => 'blue',
            self::Processing => 'indigo',
            self::Shipped    => 'purple',
            self::Delivered  => 'teal',
            self::Completed  => 'green',
            self::Cancelled  => 'red',
            self::Refunded   => 'gray',
        };
    }

    public function badge(): string
    {
        return match($this) {
            self::Pending    => 'bg-yellow-100 text-yellow-800',
            self::Paid       => 'bg-blue-100 text-blue-800',
            self::Processing => 'bg-indigo-100 text-indigo-800',
            self::Shipped    => 'bg-purple-100 text-purple-800',
            self::Delivered  => 'bg-teal-100 text-teal-800',
            self::Completed  => 'bg-green-100 text-green-800',
            self::Cancelled  => 'bg-red-100 text-red-800',
            self::Refunded   => 'bg-gray-100 text-gray-800',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
