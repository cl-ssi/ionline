<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        /* TODO: no utilizar estos middleware ya que si caga la BD no se podría pasar a modo mantenimiento */
        $this->middleware('auth');
        $this->middleware('can:be god');
    }
    
    /**
    * Single action controller
    */
    public function __invoke($param = null)
    {
        $maintenance = file_exists(storage_path('framework/down'));

        echo "<h1>System Status:</h1>";

        if(!env('MAINTENANCE_TOKEN',null))
        {
            return "MAINTENANCE_TOKEN is not set";
        }

        if($param == 'up')
        {
            Artisan::call('up');
            return redirect('/maintenance');
        }
        if($param == 'down')
        {
            Artisan::call('down --secret='. env('MAINTENANCE_TOKEN'));
            return redirect('/maintenance');
        }

        if($maintenance)
        {
            echo '<h2 style="color: red">DOWN</h2>';
            echo "<hr>";
            echo '<h3>DOWN - <a href="/maintenance/up">UP</a></h3>';
            echo '<h3><a href="/' . env('MAINTENANCE_TOKEN').'">Ir al index en modo mantenimiento</a>';
        }
        else
        {
            echo '<h2 style="color: green">UP</h2>';
            echo "<hr>";
            echo '<h3><a href="/maintenance/down">DOWN</a> - UP</h3>';
            echo '<h3><a href="/home">Ir al home</a>';
        }

    }
}
