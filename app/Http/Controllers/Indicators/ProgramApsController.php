<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Models\Indicators\Establecimiento;
use App\Models\Indicators\HealthGoal;
use App\Models\Indicators\Indicator;
use App\Models\Indicators\Percapita;
use App\Models\Indicators\ProgramAps;
use App\Models\Indicators\Rem;
use App\Models\Indicators\Value;
use App\Models\Commune;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramApsController extends Controller
{
    public function index()
    {
        return view('indicators.programming_aps.index');
    }

    public function show(Request $request, $year, $commune_id)
    {
        if(!in_array($commune_id, range(0,8)) OR !preg_match('/^\d+$/', $commune_id)) abort(404);
        $establishments_filter = $request->has('establishments_filter') ? $request->establishments_filter : null;
        $establishments_list = $request->has('establishments_list') ? unserialize($request->establishments_list) : null;
        $program_aps = ProgramAps::where('year', $year)->firstOrFail();
        
        if($establishments_filter){
            $establishments = array();
            foreach($establishments_filter as $establishment_code) 
                $establishments[] = $establishments_list[$establishment_code];
            $program_aps->load(['tracers' => function ($query) use ($establishments) {
                $query->with(['values' => function($query2) use ($establishments){
                    return $query2->whereIn('establishment', $establishments);
                }]);
             }]);
        }else{
            $program_aps->load('tracers.values');
        }
        $this->loadValuesWithRemSource($year, $commune_id, $program_aps, $establishments_filter);
        // return $program_aps;
        return view('indicators.programming_aps.show', compact('program_aps', 'commune_id', 'establishments_filter'));
    }

    private function loadValuesWithRemSource($year, $commune_id, $program_aps, $establishments_filter)
    {
        $communes = array(1 => 'COLCHANE', 2 => 'HUARA', 3 => 'CAMIÑA', 4 => 'POZO ALMONTE', 5 => 'PICA', 6 => 'IQUIQUE', 7 => 'ALTO HOSPICIO', 8 => 'HECTOR REYNO');
        $establishments = array();
        $innerHR = $year == 2022; // Se indica que CGU Dr. Héctor Reyno no programó para este año, su producción debe ser sumada a la comuna de Alto Hospicio
        // Procesamos los numerador por rem
        foreach($program_aps->tracers as $tracer){
            //Comsultas REM numerador
            if($tracer->numerator_cods != null && $tracer->numerator_cols != null){
                //procesamos los datos necesarios para todas consultas rem que se necesiten para la trazadora
                $cods_array = array_map('trim', explode(';', $tracer->numerator_cods));
                $cols_array = array_map('trim', explode(';', $tracer->numerator_cols));
                
                for($i = 0; $i < count($cods_array); $i++){
                    //procesamos los datos necesarios por cada consultas rem
                    $cods = array_map('trim', explode(',', $cods_array[$i]));
                    $cols = array_map('trim', explode(',', $cols_array[$i]));
                    $raws = null;
                    foreach($cols as $col)
                        $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                    $raws .= ' AS valor, IdEstablecimiento, Mes';

                    $result = Rem::year($year)->selectRaw($raws)
                    ->when($commune_id != 0, function($query){ return $query->with('establecimiento'); })
                    ->when(isset($communes[$commune_id]) && $commune_id != 8, function($q) use ($communes, $commune_id, $innerHR){
                        return $q->whereHas('establecimiento', function($q2) use ($communes, $commune_id, $innerHR){
                            return $q2->where('comuna', $communes[$commune_id])
                                      ->when(!$innerHR, function($q3){
                                          return $q3->where('Codigo', '!=', 102307);
                                      });
                            });
                    })
                    ->when(isset($communes[$commune_id]) && $commune_id == 8, function($q){
                        return $q->whereHas('establecimiento', function($q2){
                            return $q2->where('Codigo', 102307);
                            });
                    })
                    ->whereIn('CodigoPrestacion', $cods)
                    // ->whereIn('Mes',[1,2,3,4,5,6,7,8,9,10,11])
                    ->whereNotIn('IdEstablecimiento', ['102100','102600','102601','102602','102011'])
                    ->when($establishments_filter, function($q3) use ($establishments_filter){
                        return $q3->whereIn('IdEstablecimiento', $establishments_filter);
                    })
                    ->groupBy('Mes')->orderBy('Mes')->get();

                    foreach($result as $item){
                        $value = new Value(['month' => $item->Mes, 'factor' => 'numerador', 'value' => $item->valor]);
                        if($commune_id != 0){ // No es resumen por lo que procedo a guardar comuna y establecimiento del valor
                            $value->commune = $commune_id != 8 ? $item->establecimiento->comuna : $communes[$commune_id];
                            $value->establishment = $commune_id != 8 ? $item->establecimiento->alias_estab : null;
                            if($commune_id != 8 && !request()->has('establishments_list')) $establishments[$item->IdEstablecimiento] = $value->establishment; //No es necesario ejecutar si el valor viene del Hector Reyno
                        }
                        $tracer->values->add($value);
                    }
                }
            }
        }

        // Procesamos los denominadores por comuna
        foreach($program_aps->tracers as $tracer){
            // Consultamos si existen en el denominador asignación de valores manuales por comuna
            if($tracer->denominator_values_by_commune != null){
                $values = array_map('trim', explode(',', $tracer->denominator_values_by_commune));
                if($commune_id == 0){ //RESUMEN denominador
                    foreach($values as $value){
                        if(!empty($value)){ //valores distinto a 0 los procesamos
                            $value = new Value(['month' => 12, 'factor' => 'denominador', 'value' => (int)$value]);
                            $tracer->values->add($value);
                        }
                    }
                } else {
                    // seteo valor denominador para comuna o establecimientos seleccionados
                    if(!empty($values[$commune_id-1])){ //valor distinto a 0 lo procesamos
                        $value = new Value(['month' => 12, 'factor' => 'denominador', 'value' => (int)$values[$commune_id-1]]);
                        $value->commune = $communes[$commune_id];
                        $tracer->values->add($value);
                    }
                }
            }
        }

        $program_aps->establishments = request()->has('establishments_list') ? unserialize(request()->establishments_list) : $establishments;
        $program_aps->innerHR = $innerHR;
        if($innerHR) unset($communes[8]); //se quita Hector Reyno del listado
        $program_aps->communes = $communes;
    }
}
