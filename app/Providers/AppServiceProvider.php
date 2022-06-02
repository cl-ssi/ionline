<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;	
use Illuminate\Support\Facades\File;

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
        Blade::directive('active', function ($route) {
            //$route = array('home','login');
            if (is_array($route)) {
                return in_array(request()->is(), $route) ? 'active' : '';
            }
            return request()->is($route) ? 'active' : '';
        });


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


        DB::listen(function ($query) {
            // $location = collect(debug_backtrace())->filter(function ($trace) {
            //     return !str_contains($trace['file'], 'vendor/');
            // })->first(); // grab the first element of non vendor/ calls

            // $bindings = implode(", ", $query->bindings); // format the bindings as string

            // Log::info("
            //        ------------
            //        Sql: $query->sql
            //        Bindings: $bindings
            //        Time: $query->time
            //        File: {$location['file']}
            //        Line: {$location['line']}
            //        ------------
            // ");
            // $query->sql; // the sql string that was executed
            // $query->bindings; // the parameters passed to the sql query (this replace the '?'s in the sql string)
            // $query->time; // the time it took for the query to execute;

            Log::info($query->sql);
            Log::info($query->bindings);
            Log::info($query->time);
        });

        Paginator::useBootstrap();
    }
}
