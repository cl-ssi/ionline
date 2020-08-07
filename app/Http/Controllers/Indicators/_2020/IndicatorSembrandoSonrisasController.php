<?php

namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndicatorSembrandoSonrisasController extends Controller
{
    public function index()
    {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        return view('indicators.aps.2020.sembrando_sonrisas.index');
    }

    public function servicio() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/sembrando_sonrisas/servicio.php');

        return view('indicators.aps.2020.sembrando_sonrisas.servicio', compact('data_servicio2020', 'label'));
    }

    public function aps() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/sembrando_sonrisas/aps.php');

        return view('indicators.aps.2020.sembrando_sonrisas.aps', compact('data2020', 'label'));
    }
}
