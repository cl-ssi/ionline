<?php

namespace App\Http\Controllers\Indicators\_2019;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;

class Indicator18834Controller extends Controller
{
    public function index()
    {
        include('18834/servicio.php');
        include('18834/hospital.php');
        include('18834/reyno.php');
        return view('indicators.18834.2019.index', compact('data13','data14','data17','data18','data31',
                                                           'data19_hosp','data20_hosp','data14_hosp','data15_hosp','data16_hosp','data17_hosp','data18_hosp','data31_hosp',
                                                           'data11_reyno','data12_reyno','data13_reyno','data17_reyno','data31_reyno'));
    }

    public function servicio() {
        /***********************************/
        /*********** SERVICIO **************/
        /***********************************/
        include('18834/servicio.php');
        return view('indicators.18834.2019.servicio',
            compact('data13','data14','data17','data18','data31'));
    }


    public function hospital() {
        /**********************************/
        /*********** HOSPITAL**************/
        /**********************************/
        include('18834/hospital.php');
        return view('indicators.18834.2019.hospital',
            compact('data19_hosp','data20_hosp','data14_hosp','data15_hosp','data16_hosp','data17_hosp','data18_hosp','data31_hosp'));
    }



    public function reyno(){
        /********************************/
        /************ REYNO *************/
        /********************************/
        include('18834/reyno.php');
        return view('indicators.18834.2019.reyno',
            compact('data11_reyno','data12_reyno','data13_reyno','data17_reyno','data31_reyno'));
    }
}
