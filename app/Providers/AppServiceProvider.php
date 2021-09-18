<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use NumberFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        Blade::directive('moeda', function ($expression) {
            return "<?php echo 'R$ ' . number_format($expression, 2, ',', '.'); ?>";
        });
        
        Blade::directive('data', function ($expression) {
            return "<?php echo date('d/m/Y', strtotime($expression)); ?>";
        });

        Blade::directive('peso', function ($expression) {
            return "<?php echo number_format($expression, 3, ',', '.'); ?>";
        });

        Blade::directive('fator', function ($expression) {
            return "<?php echo number_format($expression, 1, ',', '.'); ?>";
        });
    }
}
