<?php

namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndicatorPespiController extends Controller
{
    public function index()
    {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        return view('indicators.aps.2020.pespi.index');
    }

    public function aps() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/pespi/aps.php');

        return view('indicators.aps.2020.pespi.aps', compact('data2020', 'label'));
    }

    public function reyno() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/pespi/reyno.php');

        return view('indicators.aps.2020.pespi.reyno', compact('data_reyno2020', 'label'));
    }
}
