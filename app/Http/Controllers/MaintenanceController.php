<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{ 

    /**
    * Index maintenance
    * incorporar en CheckForMaintenanceMode.php la ruta 'maintenance'
    */
    public function index()
    {
        if(!env('MAINTENANCE_TOKEN',null))
        {
            return "MAINTENANCE_TOKEN is not set";
        }

        $maintenance = file_exists(storage_path('framework/down'));

        echo "<h1>System Status: </h1>";

        if($maintenance)
        {
            echo '<h2 style="color: red">DOWN</h2>';
            $buttonLabel = 'Up';
        }
        else
        {
            echo '<h2 style="color: green">UP</h2>';
            $buttonLabel = 'Down';
        }

        echo "<hr>";

        echo '<form method="post" action="'.route('maintenance.toggle').'">';
        echo '  <input type="hidden" name="_token" value="'.csrf_token() .'">';
        echo '  Token de mantenimiento: <input type="text" name="maintenance_token" required>';
        echo '  php artisan <input type="submit" name="command" value="'.$buttonLabel.'">';
        echo '</form>';
        
        echo '[ <a href="/' . env('MAINTENANCE_TOKEN').'">Ir al index en modo mantenimiento</a> ] - ';
        echo '[ <a href="/home">Ir al home</a> ]';
    }


    /**
    * Toggle php artisan up or down
    */
    public function toggle(Request $request)
    {
        if(env('MAINTENANCE_TOKEN',null))
        {
            if(env('MAINTENANCE_TOKEN') == $request->input('maintenance_token'))
            {
                switch($request->input('command'))
                {
                    case 'Up':
                        Artisan::call('up');
                        break;
                    case 'Down':
                        Artisan::call('down --secret='. env('MAINTENANCE_TOKEN'));
                        break;
                }
            }
            else
            {
                echo '[ <a href="/maintenance">volver</a> ] <br><br>';
                return "invalid MAINTENANCE_TOKEN";
            }
        }
        else
        {
            echo '[ <a href="/maintenance">volver</a> ] <br><br>';
            return "MAINTENANCE_TOKEN is not set";
        }
        return redirect('/maintenance');
    }
}
