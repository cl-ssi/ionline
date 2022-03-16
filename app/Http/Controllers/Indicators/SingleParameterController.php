<?php

namespace App\Http\Controllers\Indicators;

use Illuminate\Support\Facades\DB;
use App\Indicators\SingleParameter;
use App\Establishment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Indicators\Percapita;
use App\Indicators\PercapitaOficial;
use App\Indicators\Establecimiento;
use App\Models\Commune;
use Carbon\Carbon;

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
     * @param  \App\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function show(SingleParameter $singleParameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\indicators\SingleParameter  $singleParameter
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
     * @param  \App\indicators\SingleParameter  $singleParameter
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
     * @param  \App\indicators\SingleParameter  $singleParameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(SingleParameter $singleParameter)
    {
        //
    }

    public function population(Request $request)
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');


        if ($request->type == "Preliminar") {
            if ($request->year == null) {
                $now = Carbon::now();
                $year = $now->year;
            } else {
                $year = $request->year;
            }

            $array = array();
            if ($request->etario_id != null) {
                $array = explode(" - ", $request->etario_id);
            }

            $total_pob = Percapita::year($year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                // ->with(['establecimiento' => function ($q) {
                //     return $q->where('meta_san', 1);
                // }])
                ->with('establecimiento')
                // ->whereHas('establecimiento', function ($q) {
                //     return $q->where('meta_san', 1);
                // })
                ->when($request->establishment_id != null, function ($query) use ($request) {
                    $query->where('COD_CENTRO', $request->establishment_id);
                })
                ->when($request->gender_id != null, function ($query) use ($request) {
                    $query->where('GENERO', $request->gender_id);
                })
                ->when($request->commune_name != null, function ($query) use ($request) {
                    $query->whereHas('establecimiento', function ($query) use ($request) {
                        $query->where('comuna', $request->commune_name);
                    });
                })
                ->when(count($array) == 2, function ($query) use ($array) {
                    $query->whereBetween('edad', [$array[0], $array[1]]);
                })
                ->when(count($array) == 1, function ($query) use ($array) {
                    $query->where('edad', '>', 99);
                })
                ->count();

            $pob_x_establecimientos = Percapita::year($year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->selectRaw('COUNT(*) AS valor, NOMBRE_CENTRO')
                ->with('establecimiento')
                // ->whereHas('establecimiento', function ($q) {
                //     return $q->where('meta_san', 1);
                // })
                ->when($request->establishment_id != null, function ($query) use ($request) {
                    $query->where('COD_CENTRO', $request->establishment_id);
                })
                ->when($request->gender_id != null, function ($query) use ($request) {
                    $query->where('GENERO', $request->gender_id);
                })
                ->when($request->commune_name != null, function ($query) use ($request) {
                    $query->whereHas('establecimiento', function ($query) use ($request) {
                        $query->where('comuna', $request->commune_name);
                    });
                })
                ->when(count($array) == 2, function ($query) use ($array) {
                    $query->whereBetween('edad', [$array[0], $array[1]]);
                })
                ->when(count($array) == 1, function ($query) use ($array) {
                    $query->where('edad', '>', $array[0]);
                })
                ->groupBy('NOMBRE_CENTRO')
                ->orderBy('NOMBRE_CENTRO')->get();

            $pob_x_generos = Percapita::year($year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->selectRaw('COUNT(*) AS valor, GENERO')
                ->with('establecimiento')
                // ->whereHas('establecimiento', function ($q) {
                //     return $q->where('meta_san', 1);
                // })
                ->when($request->establishment_id != null, function ($query) use ($request) {
                    $query->where('COD_CENTRO', $request->establishment_id);
                })
                ->when($request->gender_id != null, function ($query) use ($request) {
                    $query->where('GENERO', $request->gender_id);
                })
                ->when($request->commune_name != null, function ($query) use ($request) {
                    $query->whereHas('establecimiento', function ($query) use ($request) {
                        $query->where('comuna', $request->commune_name);
                    });
                })
                ->when(count($array) == 2, function ($query) use ($array) {
                    $query->whereBetween('edad', [$array[0], $array[1]]);
                })
                ->when(count($array) == 1, function ($query) use ($array) {
                    $query->where('edad', '>', $array[0]);
                })
                ->groupBy('GENERO')
                ->orderBy('GENERO')->get();

            $pob_x_comunas = Percapita::year($year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->selectRaw('count(*) AS valor, comuna')
                ->join('establecimientos', 'COD_CENTRO', '=', 'establecimientos.Codigo')
                ->with('establecimiento')
                ->when($request->establishment_id != null, function ($query) use ($request) {
                    $query->where('COD_CENTRO', $request->establishment_id);
                })
                ->when($request->gender_id != null, function ($query) use ($request) {
                    $query->where('GENERO', $request->gender_id);
                })
                ->when($request->commune_name != null, function ($query) use ($request) {
                    $query->whereHas('establecimiento', function ($query) use ($request) {
                        $query->where('comuna', $request->commune_name);
                    });
                })
                ->when(count($array) == 2, function ($query) use ($array) {
                    $query->whereBetween('edad', [$array[0], $array[1]]);
                })
                ->when(count($array) == 1, function ($query) use ($array) {
                    $query->where('edad', '>', $array[0]);
                })
                ->groupBy('comuna')
                ->orderBy('valor', 'DESC')
                ->get();

            $pob_x_etarios = Percapita::year($year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->when($request->establishment_id != null, function ($query) use ($request) {
                    $query->where('COD_CENTRO', $request->establishment_id);
                })
                ->when($request->gender_id != null, function ($query) use ($request) {
                    $query->where('GENERO', $request->gender_id);
                })
                ->when($request->commune_name != null, function ($query) use ($request) {
                    $query->whereHas('establecimiento', function ($query) use ($request) {
                        $query->where('comuna', $request->commune_name);
                    });
                })
                ->select(
                    [
                        DB::raw('(case
                                                  when EDAD >= 0 && EDAD <= 2 then "00 - 02"
                                                  when EDAD >= 3 && EDAD <= 4 then "03 - 04"
                                                  when EDAD >= 5 && EDAD <= 9 then "05 - 09"
                                                  when EDAD >= 15 && EDAD <= 19 then "15 - 19"
                                                  when EDAD >= 20 && EDAD <= 24 then "20 - 24"
                                                  when EDAD >= 25 && EDAD <= 29 then "25 - 29"
                                                  when EDAD >= 30 && EDAD <= 34 then "30 - 34"
                                                  when EDAD >= 35 && EDAD <= 39 then "35 - 39"
                                                  when EDAD >= 40 && EDAD <= 44 then "40 - 44"
                                                  when EDAD >= 45 && EDAD <= 49 then "45 - 49"
                                                  when EDAD >= 50 && EDAD <= 54 then "50 - 54"
                                                  when EDAD >= 55 && EDAD <= 59 then "55 - 59"
                                                  when EDAD >= 60 && EDAD <= 64 then "60 - 64"
                                                  when EDAD >= 65 && EDAD <= 69 then "65 - 69"
                                                  when EDAD >= 70 && EDAD <= 74 then "70 - 74"
                                                  when EDAD >= 75 && EDAD <= 79 then "75 - 79"
                                                  when EDAD >= 80 && EDAD <= 84 then "80 - 84"
                                                  when EDAD >= 85 && EDAD <= 89 then "85 - 89"
                                                  when EDAD >= 90 && EDAD <= 94 then "90 - 94"
                                                  when EDAD >= 95 && EDAD <= 99 then "95 - 99"
                                                  else "Mayor a 99"
                                                end) as "grupo"'),
                        DB::raw('sum(1) as "cantidad"')
                    ]
                )
                ->groupBy(DB::raw('grupo'))
                ->orderBy('cantidad')
                ->get();

            //filtro desde vista
            if ($request->etario_id != null) {
                foreach ($pob_x_etarios as $key => $pob_x_etario) {
                    if ($pob_x_etario->grupo != $request->etario_id) {
                        unset($pob_x_etarios[$key]);
                    }
                }
            }
        } else {
            if ($request->year == 2022) {

                $array = array();
                if ($request->etario_id != null) {
                    $array = explode(" - ", $request->etario_id);
                }

                $sexo = null;
                if ($request->gender_id == 'M') {
                    $sexo = "Hombres";
                } else if ($request->gender_id == 'F') {
                    $sexo = "Mujeres";
                } else {
                    $sexo = "Sin. Info.";
                }
                if ($request->year == null) {
                    $now = Carbon::now();
                    $year = $now->year;
                } else {
                    $year = $request->year;
                }

                $total_pob = PercapitaOficial::year($year)
                    ->when($request->establishment_id != null, function ($query) use ($request) {
                        $query->where('Id_Centro_APS', $request->establishment_id);
                    })
                    ->when($request->gender_id != null, function ($query) use ($sexo) {
                        $query->where('Sexo', $sexo);
                    })
                    ->when($request->commune_name != null, function ($query) use ($request) {
                        $query->where('Comuna', $request->commune_name);
                    })
                    ->when(count($array) == 2, function ($query) use ($array) {
                        $query->whereBetween('Edad', [$array[0], $array[1]]);
                    })
                    ->when(count($array) == 1, function ($query) use ($array) {
                        $query->where('edad', '>', 99);
                    })
                    ->sum('Inscritos');

                $pob_x_establecimientos = PercapitaOficial::year($year)
                    ->selectRaw('sum(Inscritos) AS valor, Id_Centro_APS, Centro_APS')
                    ->when($request->establishment_id != null, function ($query) use ($request) {
                        $query->where('Id_Centro_APS', $request->establishment_id);
                    })
                    ->when($request->gender_id != null, function ($query) use ($sexo) {
                        $query->where('Sexo', $sexo);
                    })
                    ->when($request->commune_name != null, function ($query) use ($request) {
                        $query->where('Comuna', $request->commune_name);
                    })
                    ->when(count($array) == 2, function ($query) use ($array) {
                        $query->whereBetween('Edad', [$array[0], $array[1]]);
                    })
                    ->when(count($array) == 1, function ($query) use ($array) {
                        $query->where('edad', '>', 99);
                    })
                    //->sum('Inscritos')
                    ->groupBy('Centro_APS')
                    ->orderBy('Centro_APS')
                    ->get();

                $pob_x_comunas = PercapitaOficial::year($year)
                    ->selectRaw('sum(Inscritos) AS valor, Comuna')
                    ->when($request->establishment_id != null, function ($query) use ($request) {
                        $query->where('Id_Centro_APS', $request->establishment_id);
                    })
                    ->when($request->gender_id != null, function ($query) use ($sexo) {
                        $query->where('Sexo', $sexo);
                    })
                    ->when($request->commune_name != null, function ($query) use ($request) {
                        $query->where('Comuna', $request->commune_name);
                    })
                    ->when(count($array) == 2, function ($query) use ($array) {
                        $query->whereBetween('Edad', [$array[0], $array[1]]);
                    })
                    ->when(count($array) == 1, function ($query) use ($array) {
                        $query->where('edad', '>', 99);
                    })
                    ->groupBy('Comuna')
                    ->orderBy('valor', 'DESC')
                    ->get();



                $pob_x_etarios = PercapitaOficial::year($year)
                    ->when($request->establishment_id != null, function ($query) use ($request) {
                        $query->where('Id_Centro_APS', $request->establishment_id);
                    })
                    ->when($request->gender_id != null, function ($query) use ($sexo) {
                        $query->where('Sexo', $sexo);
                    })
                    ->when($request->commune_name != null, function ($query) use ($request) {
                        $query->where('Comuna', $request->commune_name);
                    })
                    ->select(
                        [
                            DB::raw('(case
                                              when EDAD >= 0 && EDAD <= 2 then "00 - 02"
                                              when EDAD >= 3 && EDAD <= 4 then "03 - 04"
                                              when EDAD >= 5 && EDAD <= 9 then "05 - 09"
                                              when EDAD >= 15 && EDAD <= 19 then "15 - 19"
                                              when EDAD >= 20 && EDAD <= 24 then "20 - 24"
                                              when EDAD >= 25 && EDAD <= 29 then "25 - 29"
                                              when EDAD >= 30 && EDAD <= 34 then "30 - 34"
                                              when EDAD >= 35 && EDAD <= 39 then "35 - 39"
                                              when EDAD >= 40 && EDAD <= 44 then "40 - 44"
                                              when EDAD >= 45 && EDAD <= 49 then "45 - 49"
                                              when EDAD >= 50 && EDAD <= 54 then "50 - 54"
                                              when EDAD >= 55 && EDAD <= 59 then "55 - 59"
                                              when EDAD >= 60 && EDAD <= 64 then "60 - 64"
                                              when EDAD >= 65 && EDAD <= 69 then "65 - 69"
                                              when EDAD >= 70 && EDAD <= 74 then "70 - 74"
                                              when EDAD >= 75 && EDAD <= 79 then "75 - 79"
                                              when EDAD >= 80 && EDAD <= 84 then "80 - 84"
                                              when EDAD >= 85 && EDAD <= 89 then "85 - 89"
                                              when EDAD >= 90 && EDAD <= 94 then "90 - 94"
                                              when EDAD >= 95 && EDAD <= 99 then "95 - 99"
                                              else "Mayor a 99"
                                            end) as "grupo"'),
                            DB::raw('sum(Inscritos) as "cantidad"')
                        ]
                    )
                    ->groupBy(DB::raw('grupo'))
                    ->orderBy('cantidad')
                    ->get();
                //filtro desde vista
                if ($request->etario_id != null) {
                    foreach ($pob_x_etarios as $key => $pob_x_etario) {
                        if ($pob_x_etario->grupo != $request->etario_id) {
                            unset($pob_x_etarios[$key]);
                        }
                    }
                }






                $pob_x_generos = PercapitaOficial::year($year)
                    ->selectRaw('sum(Inscritos) AS valor, Sexo')
                    ->when($request->establishment_id != null, function ($query) use ($request) {
                        $query->where('Id_Centro_APS', $request->establishment_id);
                    })
                    ->when($request->gender_id != null, function ($query) use ($sexo) {
                        $query->where('Sexo', $sexo);
                    })
                    ->when($request->commune_name != null, function ($query) use ($request) {
                        $query->where('Comuna', $request->commune_name);
                    })
                    ->when(count($array) == 2, function ($query) use ($array) {
                        $query->whereBetween('Edad', [$array[0], $array[1]]);
                    })
                    ->when(count($array) == 1, function ($query) use ($array) {
                        $query->where('edad', '>', 99);
                    })
                    ->groupBy('Sexo')
                    ->orderBy('Sexo', 'DESC')
                    ->get();
            } else {
                $array = array();
                if ($request->etario_id != null) {
                    $array = explode(" - ", $request->etario_id);
                }
                $total_pob = "No hay datos el año seleccionado y la fuente seleccionada";
                $pob_x_establecimientos = array();
                $pob_x_comunas = array();
                $pob_x_etarios = array();
                $pob_x_generos = array();
                //filtro desde vista
                if ($request->etario_id != null) {
                    foreach ($pob_x_etarios as $key => $pob_x_etario) {
                        if ($pob_x_etario->grupo != $request->etario_id) {
                            unset($pob_x_etarios[$key]);
                        }
                    }
                }
            }
        }
        if ($request->year == null) {
            $now = Carbon::now();
            $year = $now->year;
        } else {
            $year = $request->year;
        }
        $establishments = Establecimiento::year($year)->get();
        foreach ($establishments as $key => $establishment) {
            $establishment->deis = str_replace("-", "", $establishment->deis);
        }

        $communes = Commune::all();

        return view('indicators.population', compact(
            'total_pob',
            'pob_x_establecimientos',
            'pob_x_comunas',
            'pob_x_etarios',
            'pob_x_generos',
            'request',
            'establishments',
            'communes'
        ));
    }
}
