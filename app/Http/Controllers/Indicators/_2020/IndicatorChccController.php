<?php

namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndicatorChccController extends Controller
{
    public function index()
    {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        // include('19813/indicator1.php');

        return view('indicators.aps.2020.chcc.index');
    }

    public function aps() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/chcc/aps.php');

        return view('indicators.aps.2020.chcc.aps', compact('data2020', 'label'));
    }

    public function reyno() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/chcc/reyno.php');

        return view('indicators.aps.2020.chcc.reyno', compact('data_reyno2020', 'label'));
    }

    public function hospital() {
        $sql_ultimo_rem = "SELECT MAX(Mes) as ultimo_rem FROM 2020rems;";
        $ultimo_rem = DB::connection('mysql_rem')->select($sql_ultimo_rem)[0]->ultimo_rem;

        include('aps/chcc/hospital.php');

        return view('indicators.aps.2020.chcc.hospital', compact('data_hosp2020', 'label'));
    }
}
