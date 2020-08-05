<?php

namespace App\Http\Controllers\Indicators\_2020;

use App\Http\Controllers\Controller;

class Indicator18834Controller extends Controller
{
    public function index()
    {
        include('18834/servicio.php');
        include('18834/hospital.php');
        include('18834/reyno.php');
        return view('indicators.18834.2020.index', compact('data13', 'data15', 'data18', 'data12', 'data31'));
    }

    public function servicio() {
        /***********************************/
        /*********** SERVICIO **************/
        /***********************************/
        include('18834/servicio.php');
        return view('indicators.18834.2020.servicio',
            compact('data13', 'data15', 'data18', 'data12', 'data31', 'last_year'));
    }


    public function hospital() {
        /**********************************/
        /*********** HOSPITAL**************/
        /**********************************/
        include('18834/hospital.php');
        return view('indicators.18834.2020.hospital',
            compact('data15_hosp', 'data16_hosp', 'data17_hosp', 'data18_hosp',
            'data19_hosp', 'data14_hosp', 'data31_hosp'));
    }



    public function reyno(){
        /********************************/
        /************ REYNO *************/
        /********************************/
        include('18834/reyno.php');
        return view('indicators.18834.2020.reyno',
            compact('data11_reyno', 'data12_reyno', 'data13_reyno', 'data18_reyno', 'data31_reyno', 'last_year'));
    }
}
