<?php

namespace App\Http\Controllers\Indicators;

use Illuminate\Support\Facades\DB;
use App\Models\Indicators\SingleParameter;
use App\Models\Establishment;
use App\Exports\PercapitaExport;
use App\Exports\PercapitaOficialExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Indicators\Percapita;
use App\Models\Indicators\PercapitaOficial;
use App\Models\Indicators\Establecimiento;
use App\Models\Commune;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class SingleParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$parameters = SingleParameter::Where('year',date('Y'))
                        ->orderBy('law', 'ASC')
                        ->orderBy('establishment_id', 'ASC')
                        ->orderBy('indicator', 'ASC')
                        ->get();*/
        $parameters = SingleParameter::Search($request)
            ->orderBy('created_at', 'DESC')
            ->orderBy('law', 'ASC')
            ->orderBy('establishment_id', 'ASC')
            ->orderBy('indicator', 'ASC')
            ->get();
        return view('indicators.single_parameter.index', compact('parameters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = Establishment::All();
        return view('indicators.single_parameter.create', compact('establishments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $singleParameter = SingleParameter::create($request->all());

        session()->flash('info', 'El parametro ' . $singleParameter->indicator . '
        del la ley ' . $singleParameter->law . ' año ' . $singleParameter->year . '
        ha sido creado.');

        return redirect()->route('indicators.single_parameter.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function show(SingleParameter $singleParameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function edit(SingleParameter $singleParameter)
    {
        $establishments = Establishment::All();
        return view(
            'indicators.single_parameter.edit',
            compact('singleParameter', 'establishments')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SingleParameter $singleParameter)
    {
        $singleParameter->fill($request->all());

        $singleParameter->save();

        session()->flash('info', 'El parametro ' . $singleParameter->indicator . '
            del la ley ' . $singleParameter->law . ' año ' . $singleParameter->year . '
            ha sido actualizado.');

        return redirect()->route('indicators.single_parameter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(SingleParameter $singleParameter)
    {
        //
    }

    public function population(Request $request){
        $total_pob = null;

        set_time_limit(3600);
        ini_set('memory_limit', '1024M');

        if ($request->type == "Preliminar") {
            $new_etario = $request->etario_id;

            if(in_array('>=100', $new_etario)){
                $max_edad = $total_pob = Percapita::year($request->year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->max('Edad');
                array_pop($new_etario);

                foreach (range(100, $max_edad) as $edad) {
                    $new_etario[] = $edad;
                }
            }

            $total_pob = Percapita::year($request->year)
                ->join($request->year.'establecimientos', 'COD_CENTRO', '=', $request->year.'establecimientos.Codigo')
                ->selectRaw('count(*) AS valor, Nombre_Centro, GENERO, Edad, comuna')
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->whereIn('COD_CENTRO', $request->establishment_id)
                ->whereIn('GENERO', $request->gender_id)
                ->when(count($request->etario_id) != 101, function ($query) use ($new_etario) {
                    $query->whereIn('Edad', $new_etario);
                })
                ->groupBy('Nombre_Centro', 'comuna', 'Genero', 'Edad')
                ->orderBy('comuna')
                ->orderBy('Nombre_Centro')
                ->orderBy('GENERO')
                ->orderBy('Edad')
                ->get();
        }
        //PERCAPITA DEFINITIVO
        else {
            if ($request->year >= 2022) {
                $sexo = [];
                foreach ($request->gender_id as $key => $gender) {
                    switch ($gender) {
                        case 'M':
                            $sexo[] = "Hombres";
                            break;
                        case 'F':
                            $sexo[] = "Mujeres";
                            break;
                        case 'I':
                            $sexo[] = "Sin. Info.";
                            break;
                    }
                }

                $year = $request->year;

                $new_etario = $request->etario_id;

                if(in_array('>=100', $new_etario)){
                    $max_edad = $total_pob = PercapitaOficial::year($year)
                    ->max('Edad');
                    array_pop($new_etario);

                    foreach (range(100, $max_edad) as $edad) {
                        $new_etario[] = $edad;
                    }
                }

                $total_pob = PercapitaOficial::year($year)
                  ->selectRaw('sum(Inscritos) AS valor, Id_Centro_APS, Centro_APS, Comuna, Sexo, Edad')
                  ->whereIn('Id_Centro_APS', $request->establishment_id)
                  ->whereIn('Sexo', $sexo)
                  ->when(count($request->etario_id) != 101, function ($query) use ($new_etario) {
                      $query->whereIn('Edad', $new_etario);
                  })
                  ->groupBy('Centro_APS', 'Sexo', 'Edad')
                  ->orderBy('Comuna')
                  ->orderBy('Centro_APS')
                  ->orderBy('Sexo')
                  ->orderBy('Edad')
                  ->get();
                
                // Edad: 9999 => adultos mayores de 111 o + años
                $total_pob->transform(function ($item, $key) {
                    if($item->Edad == 9999) $item->Edad = "111 o más";
                    return $item;
                });
            }
            else{
                $total_pob = collect(new PercapitaOficial);
            }
        }

        return view('indicators.population', compact(
            'total_pob',
            'request'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download($request->type == 'Definitivo' ? new PercapitaOficialExport($request) : new PercapitaExport($request), 'percapita_'.strtolower($request->type).'_'.Carbon::now()->format('Y_m_d_H_i_s').'.xlsx');
    }
}
