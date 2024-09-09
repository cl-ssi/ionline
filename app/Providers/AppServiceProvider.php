<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        /** Para que los Policies tengan la misma estructura de los modelos */
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // Reemplaza 'App\Models' por 'App\Policies' y añade 'Policy' al final del nombre de la clase
            $policyClass = str_replace('App\Models', 'App\Policies', $modelClass).'Policy';

            return $policyClass;
        });

        // FIXME: esto ya no debería ser necesario, se utiliza ASSET_URL en .env
        if (config('app.env') === 'production' or config('app.env') === 'testing') {
            \URL::forceScheme('https');
        }

        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)?($expression)->format('Y-m-d H:i:s'):''; ?>";
        });

        /* Helper para imprimir un número con separador de miles */
        Blade::directive('numero', function ($numero) {
            return "<?php echo number_format($numero ?? 0, 0, '.', '.'); ?>";
        });

        /* Helper para imprimir un número decimal con separador de miles */
        Blade::directive('numero_decimal', function ($numero) {
            return "<?php echo number_format($numero, 2, '.', '.'); ?>";
        });

        setlocale(LC_ALL, config('app.locale'));
        Paginator::useBootstrap();
    }
}
