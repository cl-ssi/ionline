<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Models\Indicators\Establecimiento;
use App\Models\Indicators\Prestacion;
use App\Models\Indicators\Rem;
use App\Models\Indicators\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class RemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year, $serie)
    {
        if(!Prestacion::exists($year) OR !Seccion::exists($year)) abort(404);
        $Nseries = Prestacion::year($year)->select('descripcion', 'Nserie')->where('serie', $serie)->orderBy('Nserie', 'ASC')->orderBy('id_prestacion', 'ASC')->get();
        if($Nseries->isEmpty()) abort(404);
        $Nseries = $Nseries->unique('Nserie');
        foreach($Nseries as $nserie){
            $nserie->active = Seccion::year($year)->where('serie', $serie)->where('Nserie', $nserie->Nserie)->exists();
            if($nserie->Nserie == 'A21') $nserie->otherSections = Seccion::year($year)->where('serie', $serie)->where('Nserie', $nserie->Nserie)->where('name', '!=', 'A')->select('name')->distinct()->pluck('name')->toArray();
        }
        return view('indicators.rem.list', compact('Nseries', 'year', 'serie'));
    }

    public function list($year)
    {
        if(!Prestacion::exists($year) OR !Seccion::exists($year)) abort(404);
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
     * @param  \App\Models\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $year, $serie, $nserie, $unique = null)
    {
        if(!Prestacion::exists($year) OR !Seccion::exists($year)) abort(404);
        $establecimientos = Establecimiento::year($year)->orderBy('comuna')->get();
        $prestacion = Prestacion::year($year)->where('serie', $serie)->where('Nserie', $nserie)->orderBy('id_prestacion')->first();
        if($prestacion == null) return abort(404);
        $establecimiento = $request->get('establecimiento');
        $periodo = $request->get('periodo');
        $secciones = null;
        if ($request->has('submit')) {
            $secciones = Seccion::year($year)->where('serie', $serie)->where('Nserie', $nserie)
                                ->when($nserie == 'A21', function($q) use ($unique){
                                    return $q->where('name', $unique ? '=' : '!=', 'A');
                                })->orderBy('name')->get();
            foreach($secciones as $seccion){
                $seccion->cods = array_map('trim', explode(',', $seccion->cods));
                $seccion->cols = array_map('trim', explode(',', $seccion->cols));
                $seccion->prestaciones = Prestacion::year($year)->with(['rems' => function($q) use ($establecimiento, $periodo){
                                                    $q->whereIn('IdEstablecimiento', $establecimiento)->whereIn('Mes', $periodo);
                                            }])
                                            ->whereIn('codigo_prestacion', $seccion->cods)->orderBy('id_prestacion')->get();
            }
        }
        
        return view('indicators.rem.show', compact('year', 'establecimientos', 'prestacion', 'establecimiento', 'periodo', 'secciones', 'unique'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indicators\Rem  $rem
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
     * @param  \App\Models\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rem $rem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indicators\Rem  $rem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rem $rem)
    {
        //
    }
}
