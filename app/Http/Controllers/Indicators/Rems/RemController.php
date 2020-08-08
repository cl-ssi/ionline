<?php

namespace App\Http\Controllers\Indicators\Rems;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemController extends Controller
{

    /*public function index($year, $serie, $id)
    {
        //dd("rems.$serie.$id");
        return view("rem/$year/$serie/$id")->withYear($year)->withSerie($serie)->withId($id);
    }*/

    public function index()
    {
        return view('indicators.rem.index');
    }

    public function index_serie_year($year, $serie)
    {
        return view('indicators.rem.'.$year.'.'.$serie.'.index');
    }

    public function a01($year, $serie, $nserie)
    {
        $establecimientos[] = 0;
        $periodo[] = 0;
        return view('indicators.rem.'.$year.'.'.$serie.'.'.$nserie.'.'.$nserie)->withYear($year)->withSerie($serie)->withNserie($nserie)->withEstablecimientos($establecimientos)->withPeriodo($periodo);
    }

    public function show(Request $request, $year, $serie, $nserie)
    {
        $establecimientos = $request->input('establecimiento');
        $periodo = $request->input('periodo');
        if($establecimientos == null OR $periodo == null){
            $establecimientos[] = 0;
            $periodo[] = 0;
            session()->flash('danger', 'Favor seleccionar establecimiento y periodo de consulta. (*)');
            return view('indicators.rem.'.$year.'.'.$serie.'.'.$nserie.'.'.$nserie)->withYear($year)->withSerie($serie)->withNserie($nserie)->withEstablecimientos($establecimientos)->withPeriodo($periodo);

        }
        else{
          //session()->flush();
          return view('indicators.rem.'.$year.'.'.$serie.'.'.$nserie.'.'.$nserie)->withYear($year)->withSerie($serie)->withNserie($nserie)->withEstablecimientos($establecimientos)->withPeriodo($periodo);
        }
    }

}
