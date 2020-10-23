<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Indicators\Establecimiento;
use App\Indicators\Prestacion;
use App\Indicators\Rem;
use Illuminate\Http\Request;

class RemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year, $serie)
    {
        $prestaciones = Prestacion::year($year)->select('descripcion', 'Nserie')->where('serie', $serie)->orderBy('Nserie')->get();
        $prestaciones = $prestaciones->unique('Nserie');
        
        return view('indicators.rem.list', compact('prestaciones', 'year', 'serie'));
    }

    public function list($year)
    {
        $series = Prestacion::year($year)->select('serie')->distinct()->pluck('serie')->toArray();
        return view('indicators.rem.list_series', compact('year', 'series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $year, $serie, $nserie)
    {
        $establecimientos = Establecimiento::year($year)->orderBy('comuna')->get();
        $prestacion = Prestacion::year($year)->where('serie', $serie)->where('Nserie', $nserie)->first();
        $establecimiento = $request->get('establecimiento');
        $periodo = $request->get('periodo');
        
        // $filter = ['02010101', '02010201', '02010103', '02010105'];
        // $estabs = ['102300', '102301'];
        // $months = [1];

        // $prestaciones = Prestacion::year(2018)->with(['rems' => function($q) use ($estabs, $months){
        //                                     $q->whereIn('IdEstablecimiento', $estabs)->whereIn('Mes', $months);
        //                              }])
        //                              ->whereIn('codigo_prestacion', $filter)->get();
        
        // foreach($prestaciones as $prestacion){
        //     return $prestacion->rems->sum('Col01');
        // }

        /*
        $query = 'SELECT a.codigo_prestacion,a.descripcion
                              ,sum(ifnull(b.Col01,0)) Col01
                              ,sum(ifnull(b.Col02,0)) Col02
                              ,sum(ifnull(b.Col03,0)) Col03
                              ,sum(ifnull(b.Col04,0)) Col04
                              ,sum(ifnull(b.Col05,0)) Col05
                              ,sum(ifnull(b.Col06,0)) Col06
                              ,sum(ifnull(b.Col07,0)) Col07
                              ,sum(ifnull(b.Col08,0)) Col08
                              ,sum(ifnull(b.Col09,0)) Col09
                              ,sum(ifnull(b.Col10,0)) Col10
                              ,sum(ifnull(b.Col11,0)) Col11
                              ,sum(ifnull(b.Col12,0)) Col12
                              ,sum(ifnull(b.Col13,0)) Col13
                              ,sum(ifnull(b.Col14,0)) Col14
                              ,sum(ifnull(b.Col15,0)) Col15
                              ,sum(ifnull(b.Col16,0)) Col16
                              ,sum(ifnull(b.Col17,0)) Col17
                              ,sum(ifnull(b.Col18,0)) Col18
                              ,sum(ifnull(b.Col19,0)) Col19
                              ,sum(ifnull(b.Col20,0)) Col20
                              ,sum(ifnull(b.Col21,0)) Col21
                              ,sum(ifnull(b.Col22,0)) Col22
                              ,sum(ifnull(b.Col23,0)) Col23
                              ,sum(ifnull(b.Col24,0)) Col24
                              ,sum(ifnull(b.Col25,0)) Col25
                          FROM (select c.* from 2020prestaciones c where c.codigo_prestacion in("01010101","01010103","01010201","01010203","01080001","01080002",
                                                                                            "01110106","01110107","01080030","01080040","01010601","01010603",
                                                                                            "01010901","01010903","01010401","01010403") AND c.serie = "A" ) a
                          left join 2020rems b on (a.id_prestacion=b.prestacion_id_prestacion)
                          AND (b.Mes in ('.$mes.')) AND (b.establecimiento_id_establecimiento in ('.$estab.'))
                          group by  a.codigo_prestacion,a.descripcion, a.id_prestacion
                          order by a.id_prestacion';
        */
        $prestaciones = null;
        return view('indicators.rem.show', compact('year', 'establecimientos', 'prestacion', 'establecimiento', 'periodo', 'prestaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function edit(Rem $rem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rem $rem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rem $rem)
    {
        //
    }
}
