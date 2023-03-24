<?php

namespace App\Http\Controllers\Indicators\_2020;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

class Indicator19664Controller extends Controller
{
    public function index()
    {
        return view('indicators.19664.2020.index');
    }


    public function servicio(){
        /*************************************/
        /********* SERVICIO DE SALUD *********/
        /*************************************/
        include('19664/servicio.php');

        return view('indicators.19664.2020.servicio', compact('data1', 'data2',
            'data3', 'data4', 'data6', 'data8', 'data10', 'data11', 'data12', 'last_year'));
    }

    public function hospital(){
        /*************************************/
        /********* HOSPITAL *********/
        /*************************************/
        include('19664/hospital.php');

        return view('indicators.19664.2020.hospital', compact('data4_hosp',
            'data5_hosp', 'data6_hosp', 'data7_hosp', 'data8_hosp', 'data9_hosp',
            'data10_hosp', 'data11_hosp', 'data12_hosp'));
    }

    public function reyno(){
        /*************************************/
        /********* CGU DR. REYNO *********/
        /*************************************/
        include('19664/reyno.php');

        return view('indicators.19664.2020.reyno', compact('data1_reyno', 'data2_reyno',
            'data3_reyno','data12_reyno', 'last_year'));
    }
}
