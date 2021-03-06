<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Indicators\Establecimiento;
use App\Indicators\HealthGoal;
use App\Indicators\Indicator;
use App\Indicators\Percapita;
use App\Indicators\Rem;
use App\Indicators\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HealthGoalController extends Controller
{
    public function index($law)
    {
        return view('indicators.health_goals.index', compact('law'));
    }

    public function list($law, $year)
    {
        $healthGoals = HealthGoal::where('law', $law)->where('year', $year)->orderBy('number')->get();
        if($law == '19813') $healthGoals->load('indicators');
        return view('indicators.health_goals.list', compact('healthGoals', 'law', 'year'));
    }

    public function show($law, $year, $health_goal)
    {
        if($law == '19813'){
            $indicator = Indicator::findOrFail($health_goal);
            $indicator->establishments = Establecimiento::year($year)->where('meta_san', 1)->orderBy('comuna')->get();
            $this->loadValuesWithRemSourceLaw19813($year, $indicator);
        } else {
            $healthGoal = HealthGoal::where('law', $law)->where('year', $year)->where('number', $health_goal)->firstOrFail();
            // $healthGoal->indicators()->with('values')->orderBy('number')->get();
            $healthGoal->load('indicators.values');
            $this->loadValuesWithRemSource($law, $year, $healthGoal);
        }
        return view('indicators.health_goals.show', compact($law == '19813' ? 'indicator' : 'healthGoal'));
    }

    private function loadValuesWithRemSource($law, $year, $healthGoal)
    {
        foreach($healthGoal->indicators as $indicator){
            $establishment_cods = $indicator->establishment_cods != null ? array_map('trim', explode(',',$indicator->establishment_cods)) : null; //para el filtrado especial de algunas metas

            foreach(array('numerador', 'denominador') as $factor){
                $factor_cods = $factor == 'numerador' ? $indicator->numerator_cods : $indicator->denominator_cods;
                $factor_cols = $factor == 'numerador' ? $indicator->numerator_cols : $indicator->denominator_cols;

                if($factor_cods != null && $factor_cols != null){
                    //procesamos los datos necesarios para las consultas rem
                    $cods = array_map('trim', explode(',', $factor_cods));
                    $cols = array_map('trim', explode(',', $factor_cols));
                    $raws = null;
                    foreach($cols as $col)
                        $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                    $raws .= ' AS valor, Mes';

                    //Es rem P la consulta?
                    $isRemP = Rem::year($year-1)->select('Mes')
                                ->when($healthGoal->name == 'Hospital Dr. Ernesto Torres Galdames', function($query){
                                    return $query->where('IdEstablecimiento', 102100);
                                })
                                ->when($healthGoal->name == 'Consultorio General Urbano Dr. Héctor Reyno Gutiérrez', function($query){
                                    return $query->where('IdEstablecimiento', 102307);
                                })
                                ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && Str::contains($indicator->name, 'UEH'), function($query){
                                    return $query->where('IdEstablecimiento', 102100);
                                })
                                ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && $law == '19664' && $establishment_cods == null, function($query){
                                    return $query->where('IdEstablecimiento','!=', 102100);
                                })
                                ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && $law == '19664' && $establishment_cods != null, function($query) use ($establishment_cods){
                                    return $query->whereIn('IdEstablecimiento', $establishment_cods);
                                })
                                ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->get()->count() == 2;
                    
                    if($isRemP){
                        $acum_last_year = Rem::year($year-1)
                        ->when($healthGoal->name == 'Hospital Dr. Ernesto Torres Galdames', function($query){
                            return $query->where('IdEstablecimiento', 102100);
                        })
                        ->when($healthGoal->name == 'Consultorio General Urbano Dr. Héctor Reyno Gutiérrez', function($query){
                            return $query->where('IdEstablecimiento', 102307);
                        })
                        ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && Str::contains($indicator->name, 'UEH'), function($query){
                            return $query->where('IdEstablecimiento', 102100);
                        })
                        ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && $law == '19664' && $establishment_cods == null, function($query){
                            return $query->where('IdEstablecimiento','!=', 102100);
                        })
                        ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && $law == '19664' && $establishment_cods != null, function($query) use ($establishment_cods){
                            return $query->whereIn('IdEstablecimiento', $establishment_cods);
                        })
                        ->where('Mes', 12)->whereIn('CodigoPrestacion', $cods)->sum(reset($cols));

                        $factor == 'numerador' ? $indicator->numerator_acum_last_year = $acum_last_year : $indicator->denominator_acum_last_year = $acum_last_year;
                    }
    
                    $result = Rem::year($year)->selectRaw($raws)
                                ->when($healthGoal->name == 'Hospital Dr. Ernesto Torres Galdames', function($query){
                                    return $query->where('IdEstablecimiento', 102100);
                                })
                                ->when($healthGoal->name == 'Consultorio General Urbano Dr. Héctor Reyno Gutiérrez', function($query){
                                    return $query->where('IdEstablecimiento', 102307);
                                })
                                ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && Str::contains($indicator->name, 'UEH'), function($query){
                                    return $query->where('IdEstablecimiento', 102100);
                                })
                                ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && $law == '19664' && $establishment_cods == null, function($query){
                                    return $query->where('IdEstablecimiento','!=', 102100);
                                })
                                ->when($healthGoal->name == 'Dirección Servicio Salud Iquique' && $law == '19664' && $establishment_cods != null, function($query) use ($establishment_cods){
                                    return $query->whereIn('IdEstablecimiento', $establishment_cods);
                                })
                                ->when($isRemP, function($query){
                                    return $query->whereIn('Mes', [6,12]);
                                })
                                ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
    
                    foreach($result as $item)
                        $indicator->values->add(new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]));
                }
            }
        }
    }

    private function loadValuesWithRemSourceLaw19813($year, $indicator)
    {
        foreach(array('numerador', 'denominador') as $factor){
            $factor_cods = $factor == 'numerador' ? $indicator->numerator_cods : $indicator->denominator_cods;
            $factor_cols = $factor == 'numerador' ? $indicator->numerator_cols : $indicator->denominator_cols;

            if($factor_cods != null && $factor_cols != null){
                //procesamos los datos necesarios para todas consultas rem que se necesiten para la meta sanitaria
                $cods_array = array_map('trim', explode(';', $factor_cods));
                $cols_array = array_map('trim', explode(';', $factor_cols));

                for($i = 0; $i < count($cods_array); $i++){
                    //procesamos los datos necesarios para las consultas rem o fonasa
                    $cods = array_map('trim', explode(',', $cods_array[$i]));
                    $cols = array_map('trim', explode(',', $cols_array[$i]));
                    $source = $factor == 'numerador' ? $indicator->numerator_source : $indicator->denominator_source;

                    if($source == 'FONASA'){
                        $result = Percapita::year($year)->selectRaw('COUNT(*)*'.reset($cols).' AS valor, COD_CENTRO')
                                                ->with(['establecimiento' => function($q){ 
                                                    return $q->where('meta_san', 1);
                                                }])
                                                ->whereHas('establecimiento', function($q){
                                                    return $q->where('meta_san', 1);
                                                })
                                                ->whereRaw(implode(' AND ', $cods))
                                                ->groupBy('COD_CENTRO')->orderBy('COD_CENTRO')->get();

                        foreach($result as $item){
                            $value = new Value(['month' => 12, 'factor' => $factor, 'value' => $item->valor]);
                            $value->commune = $item->establecimiento->comuna;
                            $value->establishment = $item->establecimiento->alias_estab;
                            $indicator->values->add($value);
                        }

                        // Consultamos si existen en el denominador valores manuales por comuna
                        if($factor == 'denominador' && $indicator->denominator_values_by_commune != null){
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
                    } else { // fuente REM
                        //buscamos por codigos de prestacion con valor negativo indica que existe otra consulta que necesita ser procesada para sumarle (resta) a primera consulta
                        $cods2 = null;
                        foreach($cods as $key => $value){
                            if (strpos($value, "-") !== false) {
                                $cods2[] = substr($value, 1); //le quitamos el signo negativo al codigo prestacion y guardamos valor en array $cods2
                                unset($cods[$key]); //removemos item desde $cods
                            }
                        }
                        $cols = array_map('trim', explode(',', $factor_cols));
                        $raws = null;
                        foreach($cols as $col)
                            $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                        $raws .= ' AS valor, IdEstablecimiento, Mes';

                        //Es rem P la consulta?
                        $isRemP = Rem::year($year-1)->select('Mes')
                                    ->whereHas('establecimiento',function($q){ return $q->where('meta_san', 1); })
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->get()->count() == 2;
                        if($isRemP) $factor == 'numerador' ? $indicator->isNumRemP = true : $indicator->isDenRemP = true;

                        $result = Rem::year($year)->selectRaw($raws)
                                    ->with(['establecimiento' => function($q){ 
                                        return $q->where('meta_san', 1);
                                    }])
                                    ->whereHas('establecimiento', function($q){
                                        return $q->where('meta_san', 1);
                                    })
                                    ->when($isRemP, function($query){
                                        return $query->whereIn('Mes', [6,12]);
                                    })
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                        foreach($result as $item){
                            $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]);
                            $value->commune = $item->establecimiento->comuna;
                            $value->establishment = $item->establecimiento->alias_estab;
                            $indicator->values->add($value);
                        }
                        //Existe otra consulta que ejecutar con valores negativos para sumarlos a la primera consulta
                        if($cods2 != null){
                            //Es rem P la consulta?
                            $isRemP = Rem::year($year-1)->select('Mes')
                                        ->whereHas('establecimiento',function($q){ return $q->where('meta_san', 1); })
                                        ->whereIn('CodigoPrestacion', $cods2)->groupBy('Mes')->get()->count() == 2;
                            if($isRemP) $factor == 'numerador' ? $indicator->isNumRemP = true : $indicator->isDenRemP = true;

                            $result = Rem::year($year)->selectRaw($raws)
                                        ->with(['establecimiento' => function($q){ 
                                            return $q->where('meta_san', 1);
                                        }])
                                        ->whereHas('establecimiento', function($q){
                                            return $q->where('meta_san', 1);
                                        })
                                        ->when($isRemP, function($query){
                                            return $query->whereIn('Mes', [6,12]);
                                        })
                                        ->whereIn('CodigoPrestacion', $cods2)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                            foreach($result as $item){
                                $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => -$item->valor]);
                                $value->commune = $item->establecimiento->comuna;
                                $value->establishment = $item->establecimiento->alias_estab;
                                $indicator->values->add($value);
                            }
                        }
                    }
                }
            }
        }
    }

    public function editInd($law, $year, $health_goal, Indicator $indicator)
    {
        $indicator->load('values');
        // return $indicator;
        return view('indicators.health_goals.ind.edit', compact('indicator'))->with(['healthGoal' => $indicator->indicatorable]);
    }

    public function updateInd($law, $year, $health_goal, Indicator $indicator, Request $request)
    {
        // return $request;
        $indicator->number = $request->get('number');
        $indicator->name = $request->get('name');
        $indicator->goal = $request->get('goal');
        $indicator->weighting = $request->get('weighting');
        $indicator->numerator = $request->get('numerator');
        $indicator->numerator_source = $request->get('numerator_source');
        $indicator->numerator_cods = $request->has('numerator_cods') ? $request->get('numerator_cods') : null;
        $indicator->numerator_cols = $request->has('numerator_cols') ? $request->get('numerator_cols') : null;
        $indicator->denominator = $request->get('denominator');
        $indicator->denominator_source = $request->get('denominator_source');
        $indicator->denominator_cods = $request->has('denominator_cods') ? $request->get('denominator_cods') : null;
        $indicator->denominator_cols = $request->has('denominator_cols') ? $request->get('denominator_cols') : null;
        $indicator->save();

        // si existe previamente valores y cambiamos a fuente de datos REM, nos aseguramos de borrarlos.
        if($request->has('numerator_cods')) $indicator->values()->where('factor', 'numerador')->delete();
        if($request->has('denominator_cods')) $indicator->values()->where('factor', 'denominador')->delete();

        if($request->has('numerator_month')){
            foreach($request->get('numerator_month') as $index => $value)
                if($value != null)
                    $indicator->values()->updateOrCreate(
                        ['factor' => 'numerador', 'month' => $index + 1], 
                        ['value' => $value]
                    );
                else
                    $indicator->values()->where('factor', 'numerador')->where('month', $index + 1)->delete();
        }

        if($request->has('denominator_month')){
            foreach($request->get('denominator_month') as $index => $value)
                if($value != null)
                    $indicator->values()->updateOrCreate(
                        ['factor' => 'denominador', 'month' => $index + 1], 
                        ['value' => $value]
                    );
                else
                $indicator->values()->where('factor', 'denominador')->where('month', $index + 1)->delete();
        }

        //Regresamos a los indicadores con sus respectivos valores. Es lo mismo que hay en el método show salvo por el mensaje de confirmación.
        $healthGoal = $indicator->indicatorable;
        // $indicators = $healthGoal->indicators()->with('values')->orderBy('number')->get();
        $indicators = $healthGoal->load('indicators.values');
        $this->loadValuesWithRemSource($law, $year, $healthGoal, $indicators);

        return view('indicators.health_goals.show', compact('indicators', 'healthGoal'))->with('success', 'Registros actualizados satisfactoriamente');
    }
}
