<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Models\Indicators\Aps;
use App\Models\Indicators\Establecimiento;
use App\Models\Indicators\Rem;
use App\Models\Indicators\Value;
use Illuminate\Support\Str;

class ApsController extends Controller
{
    public function index()
    {
        return view('indicators.iaps.index');
    }

    public function list($year)
    {
        $iaps = Aps::with('indicators')->where('year', $year)->orderBy('number')->get();
        $withoutAPS = $year <= 2021 ? ['102307', '102100', '102307,102100', '102100,102307'] : ['102100'];
        foreach($iaps as $item){
            $item->aps_active = $item->indicators()->count() > 0 && $item->indicators()->whereIn('establishment_cods', $withoutAPS)->count() == 0 || $item->indicators()->whereIn('establishment_cods', $withoutAPS)->count() != $item->indicators()->count();
            $item->reyno_active = $year <= 2021 && $item->indicators()->where('establishment_cods','LIKE', '%102307%')->count() > 0;
            $item->hospital_active = $item->indicators()->where('establishment_cods','LIKE', '%102100%')->count() > 0;
            $item->ssi_active = $item->indicators()->where('establishment_cods','LIKE', '%102010%')->count() > 0;
        }

        // return $iaps;
        return view('indicators.iaps.list', compact('iaps', 'year'));
    }

    public function show($year, $slug, $establishment_type)
    {
        $iaps = Aps::where('year', $year)->where('slug', $slug)->firstOrFail();

        if($iaps->slug == 'chcc'){ //Programa Chile Crece Contigo
            // $iaps->load(['indicators' => function($q) use ($establishment_type){
            //     $q->where('establishment_cods', $establishment_type == 'hospital' ? 'LIKE' : 'NOT LIKE', '102100')->with('values');
            // }]);
            $iaps->indicators = $iaps->indicators()->where('establishment_cods', $establishment_type == 'hospital' ? 'LIKE' : 'NOT LIKE', '102100')->paginate(10);
        } else {
            // $iaps->load('indicators.values');
            $iaps->indicators = $iaps->indicators()->paginate(10);
        }

        $this->loadValuesWithRemSource($year, $iaps, $establishment_type);
        // return $iaps;
        return view('indicators.iaps.show', compact('iaps'));
    }

    private function loadValuesWithRemSource($year, $iaps, $establishment_type)
    {
        $establishment_type_names = ['aps' => 'APS', 'reyno' => 'CGU Dr. Hector Reyno', 'hospital' => 'Hospital Dr. Ernesto Torres G.', 'ssi' => 'Dirección Servicio de Salud'];
        $iaps->establishment_type = $establishment_type_names[$establishment_type];
        $iaps->establishments = collect();
        $last_month_rem = Rem::year($year)->max('Mes');

        foreach($iaps->indicators as $indicator){
            foreach(array('numerador', 'denominador') as $factor){
                $factor_cods = $factor == 'numerador' ? $indicator->numerator_cods : $indicator->denominator_cods;
                $factor_cols = $factor == 'numerador' ? $indicator->numerator_cols : $indicator->denominator_cols;
                $factor_source = $factor == 'numerador' ? $indicator->numerator_source : $indicator->denominator_source;
                $factor_name = $factor == 'numerador' ? $indicator->numerator : $indicator->denominator;
                //Es otro año en vez de $year?
                $last_year = null;
                $year_counter = 0; //si se contabiliza mas de un año es porque hay dos consultas uno con el año $year y otro con el $last_year
                foreach(array_map('trim', explode(' ',$factor_name)) as $item){
                    if(is_numeric($item) && $item <= $year && $item >= 2015){
                        $year_counter++;
                        if($item != $year){
                            $last_year = $item;
                            break;
                        }
                    }
                }

                //Ruta rem con división incluída / num
                $dividedBy = 1;
                if(Str::contains($factor_source, '/')){
                    $findNum = array_map('trim', explode('/',$factor_source));
                    $dividedBy = 1 / $findNum[1];
                }
                
                $establishment_cods = null;

                if($establishment_type == 'aps'){
                    $establishment_cods = array_map('trim', explode(',',$indicator->establishment_cods));
                    $establishment_cods = array_diff($establishment_cods, $year <= 2021 ? array("102307", "102100", "102010") : array("102100", "102010")); //si es año 2021 descartar reyno, hospital y ssi caso contrario solo hospital y ssi
                    $establishments = Establecimiento::year($last_year && $year_counter == 1 ? $last_year : $year)->whereIn('Codigo', $establishment_cods)->get(['id_establecimiento','alias_estab','comuna', 'Codigo']);
                    foreach($establishments as $item)
                        if(!$iaps->establishments->where('Codigo', $item->Codigo)->count()) $iaps->establishments->add($item);
                }

                if($factor_cods != null && $factor_cols != null){
                    //procesamos los datos necesarios para todas consultas rem que se necesiten para la meta sanitaria
                    $cods_array = array_map('trim', explode(';', $factor_cods));
                    $cols_array = array_map('trim', explode(';', $factor_cols));

                    for($i = 0; $i < count($cods_array); $i++){
                        //procesamos los datos necesarios para las consultas rem
                        $cods = array_map('trim', explode(',', $cods_array[$i]));
                        $cols = array_map('trim', explode(',', $cols_array[$i]));
                        $raws = null;
                        foreach($cols as $col)
                            $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                        $raws .= ' AS valor, IdEstablecimiento, Mes';

                        $result = Rem::year($last_year && $year_counter == 1 ? $last_year : $year)->selectRaw($raws)
                                    ->when($establishment_type == 'aps', function($query) use ($establishment_cods){
                                        // return $query->with('establecimiento')->whereIn('IdEstablecimiento', $establishment_cods);
                                        return $query->whereIn('IdEstablecimiento', $establishment_cods);
                                    })
                                    ->when($establishment_type == 'reyno', function($query){
                                        return $query->where('IdEstablecimiento', 102307);
                                    })
                                    ->when($establishment_type == 'hospital' && $indicator->id == 310, function($query) use ($factor){
                                        return $factor == 'denominador' ? $query->whereIn('IdEstablecimiento', array(102300,102301,102302,102303,102308,102305,102306,102307,102308,102309,102310,102400,102402,102403,102406,200474,102407,102408,102409,102410,102411,102412,102413,102414,102415,102416,102701,102705,200335,200557)) : $query->where('IdEstablecimiento', 102100);
                                    })
                                    ->when($establishment_type == 'hospital' && $indicator->id != 310, function($query){
                                        return $query->where('IdEstablecimiento', 102100);
                                    })
                                    ->when($establishment_type == 'ssi', function($query){
                                        return $query->where('IdEstablecimiento', 102010);
                                    })
                                    ->when(Str::contains($factor_source, 'REM P'), function($query){
                                        return $query->whereIn('Mes', [6,12]);
                                    })
                                    ->when($last_year, function($query) use ($last_month_rem){
                                        return $query->where('Mes', '<=', $last_month_rem);
                                    })
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                        foreach($result as $item){
                            $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor * $dividedBy]);
                            if($establishment_type == 'aps') {
                                $value->commune = $iaps->establishments->firstWhere('Codigo', $item->IdEstablecimiento)->comuna;
                                $value->establishment = $iaps->establishments->firstWhere('Codigo', $item->IdEstablecimiento)->alias_estab;
                            }
                            $indicator->values->add($value);
                        }

                        //Existe otra consulta que ejecutar con valores negativos para sumarlos a la primera consulta
                        if($year_counter > 1){
                            $result = Rem::year($last_year)->selectRaw($raws)
                                    ->when($establishment_type == 'aps', function($query) use ($establishment_cods){
                                        // return $query->with('establecimiento')->whereIn('IdEstablecimiento', $establishment_cods);
                                        return $query->whereIn('IdEstablecimiento', $establishment_cods);
                                    })
                                    ->when($establishment_type == 'reyno', function($query){
                                        return $query->where('IdEstablecimiento', 102307);
                                    })
                                    ->when($establishment_type == 'hospital' && $indicator->id == 310, function($query) use ($factor){
                                        return $factor == 'denominador' ? $query->whereIn('IdEstablecimiento', array(102300,102301,102302,102303,102308,102305,102306,102307,102308,102309,102310,102400,102402,102403,102406,200474,102407,102408,102409,102410,102411,102412,102413,102414,102415,102416,102701,102705,200335,200557)) : $query->where('IdEstablecimiento', 102100);
                                    })
                                    ->when($establishment_type == 'hospital' && $indicator->id != 310, function($query){
                                        return $query->where('IdEstablecimiento', 102100);
                                    })
                                    ->when($establishment_type == 'ssi', function($query){
                                        return $query->where('IdEstablecimiento', 102010);
                                    })
                                    ->when(Str::contains($factor_source, 'REM P'), function($query){
                                        return $query->whereIn('Mes', [6,12]);
                                    })
                                    ->when($last_year, function($query) use ($last_month_rem){
                                        return $query->where('Mes', '<=', $last_month_rem);
                                    })
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                        foreach($result as $item){
                            $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => -$item->valor * $dividedBy]);
                            if($establishment_type == 'aps') {
                                $value->commune = $iaps->establishments->firstWhere('Codigo', $item->IdEstablecimiento)->comuna;
                                $value->establishment = $iaps->establishments->firstWhere('Codigo', $item->IdEstablecimiento)->alias_estab;
                            }
                            $indicator->values->add($value);
                        }
                        }
                    }
                }

                // Consultamos si existen en el denominador valores manuales por comuna
                if($factor == 'denominador' && $indicator->denominator_values_by_commune != null && $establishment_type != 'ssi'){
                    $values = array_map('trim', explode(',', $indicator->denominator_values_by_commune));
                    $communes = array('ALTO HOSPICIO', 'CAMIÑA', 'COLCHANE', 'HUARA', 'IQUIQUE', 'PICA', 'POZO ALMONTE');

                    foreach($values as $index => $value){
                        if(!empty($value)){ //valores distinto a 0 los procesamos
                            $commune = $communes[$index]; //obtenemos nombre de comuna segun posicion del value en el array
                            //borramos valores previos segun comuna y factor denominador
                            $indicator->values = $indicator->values->reject(function($item, $key) use ($factor, $commune){
                                return $item->factor == $factor && $item->commune == $commune;
                            });
                            // Seteamos valores nuevos segun comuna y factor denominador
                            $value = new Value(['month' => 12, 'factor' => $factor, 'value' => $value]);
                            $value->commune = $commune;
                            $indicator->values->add($value);
                        }
                    }
                }
            }
        }

        if($establishment_type == 'aps'){
            // $iaps->establishments = $iaps->establishments->unique('alias_estab');
            $iaps->communes = $iaps->establishments->unique('comuna')->pluck('comuna')->sort();
        }
        // dd($indicator->values);
    }

}
