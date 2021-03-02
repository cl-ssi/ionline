<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Indicators\HealthGoal;
use App\Indicators\Rem;
use App\Indicators\Value;
use Illuminate\Http\Request;

class HealthGoalController extends Controller
{
    public function index($law)
    {
        return view('indicators.health_goals.index', compact('law'));
    }

    public function list($law, $year)
    {
        $healthGoals = HealthGoal::where('law', $law)->where('year', $year)->orderBy('number')->get();
        return view('indicators.health_goals.list', compact('healthGoals', 'law', 'year'));
    }

    public function show($law, $year, $health_goal)
    {
        $healthGoal = HealthGoal::where('law', $law)->where('year', $year)->where('number', $health_goal)->first();
        // Nos aseguramos que el comges existe y el corte consultado se encuentre entre 1 y 4
        if($healthGoal == null) abort(404);
        $indicators = $healthGoal->indicators()->with('values')->orderBy('number')->get();
        $this->loadValuesWithRemSource($year, $healthGoal, $indicators);
        // return $indicators;
        return view('indicators.health_goals.show', compact('healthGoal', 'indicators'));
    }

    private function loadValuesWithRemSource($year, $healthGoal, $indicators)
    {
        foreach($indicators as $indicator){
            $values = collect(); //inicializamos collection de values para el indicador
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
                                    return $query->whereHas('establecimiento',function($q){
                                        return $q->where('meta_san_18834_hosp', 1);
                                    });
                                })
                                ->when($healthGoal->name == 'Consultorio General Urbano Dr. Héctor Reyno Gutiérrez', function($query){
                                    return $query->where('IdEstablecimiento', 102307);
                                })
                                ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->get()->count() == 2;
                    
                    if($isRemP){
                        $acum_last_year = Rem::year($year-1)
                        ->when($healthGoal->name == 'Hospital Dr. Ernesto Torres Galdames', function($query){
                            return $query->whereHas('establecimiento', function($q){
                            return $q->where('meta_san_18834_hosp', 1);
                            });
                        })
                        ->when($healthGoal->name == 'Consultorio General Urbano Dr. Héctor Reyno Gutiérrez', function($query){
                            return $query->where('IdEstablecimiento', 102307);
                        })
                        ->where('Mes', 12)->whereIn('CodigoPrestacion', $cods)->sum(reset($cols));

                        $factor == 'numerador' ? $indicator->numerator_acum_last_year = $acum_last_year : $indicator->denominator_acum_last_year = $acum_last_year;
                    }
    
                    $result = Rem::year($year)->selectRaw($raws)
                                ->when($healthGoal->name == 'Hospital Dr. Ernesto Torres Galdames', function($query){
                                    return $query->whereHas('establecimiento', function($q){
                                        return $q->where('meta_san_18834_hosp', 1);
                                    });
                                })
                                ->when($healthGoal->name == 'Consultorio General Urbano Dr. Héctor Reyno Gutiérrez', function($query){
                                    return $query->where('IdEstablecimiento', 102307);
                                })
                                ->when($isRemP, function($query){
                                    return $query->whereIn('Mes', [6,12]);
                                })
                                ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
    
                    foreach($result as $item)
                        $values->add(new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]));
                    $indicator->setRelation('values', $values);
                }
            }
        }
    }
}
