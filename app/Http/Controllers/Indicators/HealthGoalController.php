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
        $this->loadValuesWithRemSource($law, $year, $health_goal, $indicators);
        // return $indicators;
        return view('indicators.health_goals.show', compact('healthGoal', 'indicators'));
    }

    private function loadValuesWithRemSource($law, $year, $health_goal, $indicators)
    {
        foreach($indicators as $indicator){
            $values = collect(); //inicializamos collection de values para el indicador
            //completamos valores para el numerador
            if($indicator->numerator_cods != null){
                //procesamos los datos necesarios para las consultas rem
                $cods = explode(',', $indicator->numerator_cods);
                $cols = explode(',', $indicator->numerator_cols);
                $raws = null;
                foreach($cols as $col)
                    $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                $raws .= ' AS valor, Mes';
                //Es rem P la consulta?
                if(Rem::year($year-1)->select('Mes')->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->get()->count() == 2){
                    $indicator->numerator_acum_last_year = Rem::year($year-1)->where('Mes', 12)->whereIn('CodigoPrestacion', $cods)->sum(reset($cols));
                    $result = Rem::year($year)->selectRaw($raws)->whereIn('Mes', [6,12])->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
                }else{ //REM A
                    $result = Rem::year($year)->selectRaw($raws)->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
                }
                foreach($result as $item)
                    $values->add(new Value(['month' => $item->Mes, 'factor' => 'numerador', 'value' => $item->valor]));
                $indicator->setRelation('values', $values);
            }

            //completamos valores para el denominador
            if($indicator->denominator_cods != null){
                //procesamos los datos necesarios para las consultas rem
                $cods = explode(',', $indicator->denominator_cods);
                $cols = explode(',', $indicator->denominator_cols);
                $raws = null;
                foreach($cols as $col)
                    $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                $raws .= ' AS valor, Mes';
                //Es rem P la consulta?
                if(Rem::year($year-1)->select('Mes')->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->get()->count() == 2){ //REM P
                    $indicator->denominator_acum_last_year = Rem::year($year-1)->where('Mes', 12)->whereIn('CodigoPrestacion', $cods)->sum(reset($cols));
                    $result = Rem::year($year)->selectRaw($raws)->whereIn('Mes', [6,12])->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
                }else{
                    $result = Rem::year($year)->selectRaw($raws)->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
                }
                    
                foreach($result as $item)
                    $values->add(new Value(['month' => $item->Mes, 'factor' => 'denominador', 'value' => $item->valor]));
                $indicator->setRelation('values', $values);
            }
        }
    }
}
