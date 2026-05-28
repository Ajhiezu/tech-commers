<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Total pengguna terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Toko Aktif', Store::active()->count())
                ->description('Total toko aktif saat ini')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary'),
            Stat::make('Produk Aktif', Product::active()->count())
                ->description('Total produk yang dijual')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),
            Stat::make('Total Pesanan', Order::count())
                ->description('Keseluruhan pesanan dibuat')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),
        ];
    }
}
