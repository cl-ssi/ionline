<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;


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
        if(config('app.env') === 'production' OR config('app.env') === 'testing') {
            \URL::forceScheme('https');
        }
        
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)?($expression)->format('Y-m-d H:i:s'):''; ?>";
        });

        /* Helper para imprimir un número con separador de miles */
        Blade::directive('numero', function ($numero) {
            return "<?php echo number_format($numero, 0, '.', '.'); ?>";
        });

        /* Helper para imprimir un número decimal con separador de miles */
        Blade::directive('numero_decimal', function ($numero) {
            return "<?php echo number_format($numero, 2, '.', '.'); ?>";
        });
        
        Paginator::useBootstrap();
    }
}
