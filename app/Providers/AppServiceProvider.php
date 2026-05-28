<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Prevent lazy loading in dev
        Model::preventLazyLoading(!app()->isProduction());

        // Register observers
        Order::observe(OrderObserver::class);
        Product::observe(ProductObserver::class);

        // Blade directives
        Blade::directive('rupiah', function ($expression) {
            return "<?php echo formatRupiah($expression); ?>";
        });

        Blade::directive('tanggal', function ($expression) {
            return "<?php echo formatDate($expression); ?>";
        });
    }
}
