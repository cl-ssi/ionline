<?php

namespace App\Http\Controllers\Indicators;

use App\Http\Controllers\Controller;
use App\Imports\IndicatorValuesImport;
use App\Indicators\AttachedFile;
use App\Indicators\Establecimiento;
use App\Indicators\HealthGoal;
use App\Indicators\Indicator;
use App\Indicators\Percapita;
use App\Indicators\PercapitaOficial;
use App\Indicators\Rem;
use App\Indicators\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class HealthGoalController extends Controller
{
    public function index($law)
    {
        return view('indicators.health_goals.index', compact('law'));
    }

    public function list($law, $year)
    {
        $healthGoals = HealthGoal::where('law', $law)->where('year', $year)->orderBy('number')->get();
        $communes = null;
        if($law == '19813'){
            $healthGoals->load('indicators.values');
            $communes = Establecimiento::year($year)->where('meta_san', 1)->orderBy('comuna')->select('comuna')->distinct()->pluck('comuna')->toArray();
            foreach($healthGoals as $healthGoal)
                foreach($healthGoal->indicators as $indicator){
                    $indicator->establishments = Establecimiento::year($year)->where('meta_san', 1)->orderBy('comuna')->get();
                    $this->loadValuesWithRemSourceLaw19813($year, $indicator);
                }
            // return $healthGoals;
        }
        return view('indicators.health_goals.list', compact('healthGoals', 'law', 'year', 'communes'));
    }

    public function show($law, $year, $health_goal)
    {
        if($law == '19813'){
            $indicator = Indicator::findOrFail($health_goal);
            $currentMonth = Rem::year($year)->max('Mes');
            $indicator->currentMonth = $currentMonth;
            $indicator->load('values.attachedFiles');
            $indicator->establishments = Establecimiento::year($year)->where('meta_san', 1)->orderBy('comuna')->get();
            $this->loadValuesWithRemSourceLaw19813($year, $indicator);
        } else { // ley 18834 o 19664
            $healthGoal = HealthGoal::where('law', $law)->where('year', $year)->where('number', $health_goal)->firstOrFail();
            $healthGoal->load('indicators.values');
            $this->loadValuesWithRemSource($healthGoal);
        }
        return view('indicators.health_goals.show', compact($law == '19813' ? 'indicator' : 'healthGoal'));
    }

    private function loadValuesWithRemSource($healthGoal)
    {
        foreach($healthGoal->indicators as $indicator){
            $establishment_cods = $indicator->establishment_cods != null ? array_map('trim', explode(',',$indicator->establishment_cods)) : null; //para el filtrado por establecimientos
            $where_clause = 'WhereIn';
            if($establishment_cods){
                foreach($establishment_cods as $key => $value){
                    if (strpos($value, "!") !== false) {
                        $establishment_cods[$key] = substr($value, 1); //le quitamos el signo de exclamacion al codigo establecimiento
                        $where_clause = 'WhereNotIn'; // cualquier codigo de establecimiento que tenga un signo de exclamacion es por que necesitamos consultar al resto de establecimientos
                    }
                }
            }

            foreach(array('numerador', 'denominador') as $factor){
                $factor_cods = $factor == 'numerador' ? $indicator->numerator_cods : $indicator->denominator_cods;
                $factor_cols = $factor == 'numerador' ? $indicator->numerator_cols : $indicator->denominator_cols;
                $isRemP = $factor == 'numerador' ? $indicator->numerator_acum_last_year : $indicator->denominator_acum_last_year;

                if($factor_cods != null && $factor_cols != null){
                    //procesamos los datos necesarios para las consultas rem
                    $cods = array_map('trim', explode(',', $factor_cods));
                    $cols = array_map('trim', explode(',', $factor_cols));
                    $raws = null;
                    foreach($cols as $col)
                        $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                    $raws .= ' AS valor, Mes';
    
                    $result = Rem::year($healthGoal->year)->selectRaw($raws)
                                ->when($establishment_cods, function($query) use ($establishment_cods, $where_clause){
                                    return $query->{$where_clause}('IdEstablecimiento', $establishment_cods);
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
        $establishment_cods = $indicator->establishment_cods != null ? array_map('trim', explode(',',$indicator->establishment_cods)) : null; //para el filtrado especial de algunas metas

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

                    if(Str::contains($source, 'FONASA')){
                        if($source == 'FONASA'){ // fuente FONASA preliminar
                            $result = Percapita::year($year)->selectRaw('COUNT(*)*'.reset($cols).' AS valor, COD_CENTRO')
                                                    ->with(['establecimiento' => function($q) use ($establishment_cods){ 
                                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1); //meta_san es un campo que se empezó a ocupar en el año 2021
                                                    }])
                                                    ->whereHas('establecimiento', function($q) use ($establishment_cods){
                                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                                    })
                                                    ->whereRaw(implode(' AND ', $cods))
                                                    ->groupBy('COD_CENTRO')->orderBy('COD_CENTRO')->get();
                        }else{ //fuente FONASA definitivo
                            $result = PercapitaOficial::year($year)->selectRaw('SUM(Inscritos)*'.reset($cols).' AS valor, Id_Centro_APS')
                                                    ->with(['establecimiento' => function($q) use ($establishment_cods){ 
                                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1); //meta_san es un campo que se empezó a ocupar en el año 2021
                                                    }])
                                                    ->whereHas('establecimiento', function($q) use ($establishment_cods){
                                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                                    })
                                                    ->whereRaw(implode(' AND ', $cods))
                                                    ->groupBy('Id_Centro_APS')->orderBy('Id_Centro_APS')->get();
                        }

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
                        // dd($indicator);
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
                                    ->whereHas('establecimiento',function($q) use ($establishment_cods){ 
                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                    })
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->get()->count() == 2;
                        if($isRemP) $factor == 'numerador' ? $indicator->isNumRemP = true : $indicator->isDenRemP = true;

                        $result = Rem::year($year)->selectRaw($raws)
                                    ->with(['establecimiento' => function($q) use ($establishment_cods){ 
                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                    }])
                                    ->whereHas('establecimiento', function($q) use ($establishment_cods){
                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                    })
                                    ->when($isRemP, function($query){
                                        return $query->whereIn('Mes', [6,12]);
                                    })
                                    ->when(in_array($indicator->id, [76,341]) && $factor == 'denominador', function($query){ //N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo de DSM en su primera evaluación en control de los 18 meses, período enero a septiembre 2021
                                        return $query->whereIn('Mes', [1,2,3,4,5,6,7,8,9]);
                                    })
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                        foreach($result as $item){
                            $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]);
                            $value->commune = $item->establecimiento->comuna;
                            $value->establishment = $item->establecimiento->alias_estab;
                            $indicator->values->add($value);
                        }

                        if(in_array($indicator->id, [76,341]) && $factor == 'denominador'){
                            // N° de niños y niñas de 12 a 23 meses diagnosticados con riesgo de DSM en su primera evaluación en control de los 18 meses, período octubre 2020 a diciembre del 2020
                            $result = Rem::year($year-1)->selectRaw($raws)
                                    ->with(['establecimiento' => function($q) use ($establishment_cods){ 
                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                    }])
                                    ->whereHas('establecimiento', function($q) use ($establishment_cods){
                                        return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                    })
                                    ->whereIn('Mes', [10,11,12])
                                    ->whereIn('CodigoPrestacion', $cods)->groupBy('IdEstablecimiento','Mes')->orderBy('Mes')->get();

                            foreach($result as $item){
                                $value = new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]);
                                $value->commune = $item->establecimiento->comuna;
                                $value->establishment = $item->establecimiento->alias_estab;
                                $indicator->values->add($value);
                            }
                        }

                        //Existe otra consulta que ejecutar con valores negativos para sumarlos a la primera consulta
                        if($cods2 != null){
                            //Es rem P la consulta?
                            $isRemP = Rem::year($year-1)->select('Mes')
                                        ->whereHas('establecimiento',function($q) use ($establishment_cods){ 
                                            return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1); 
                                        })
                                        ->whereIn('CodigoPrestacion', $cods2)->groupBy('Mes')->get()->count() == 2;
                            if($isRemP) $factor == 'numerador' ? $indicator->isNumRemP = true : $indicator->isDenRemP = true;

                            $result = Rem::year($year)->selectRaw($raws)
                                        ->with(['establecimiento' => function($q) use ($establishment_cods){ 
                                            return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
                                        }])
                                        ->whereHas('establecimiento', function($q) use ($establishment_cods){
                                            return $establishment_cods ? $q->whereIn('Codigo', $establishment_cods) : $q->where('meta_san', 1);
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
        
        session()->flash('success', 'Registros actualizados satisfactoriamente.');
        return redirect()->route('indicators.health_goals.show', [$law, $year, $health_goal]);
    }

    public function importIndValues($law, $year, $health_goal, Indicator $indicator, Request $request)
    {
        // return $request;
        session()->flash('commune', str_replace(" ","_",$request->commune)); //Necesario para ubicar comuna en el conjunto de tabs
        Excel::import(new IndicatorValuesImport($indicator->id, $request->commune), $request->file);
        session()->flash('success', 'Actividades para comuna de '.$request->commune.' fueron registradas satisfactoriamente.');
        return redirect()->route('indicators.health_goals.show', [$law, $year, $indicator]);
    }

    public function storeIndValue($law, $year, $health_goal, Indicator $indicator, Value $value, Request $request)
    {
        $newValue = Value::create([
            'activity_name' => $value->activity_name,
            'month' => $request->month,
            'factor' => 'numerador',
            'commune' =>  $value->commune,
            'value' => 1,
            'valueable_id' => $value->valueable_id,
            'valueable_type' => $value->valueable_type,
        ]);

        if($request->hasFile('files')){
            foreach($request->file('files') as $file) {
                $filename = $file->getClientOriginalName();
                $fileModel = new AttachedFile();
                $fileModel->file = $file->store('ionline/indicators/health_goals/19813/'.$year,['disk' => 'gcs']);
                $fileModel->document_name = $filename;
                $fileModel->value_id = $newValue->id;
                $fileModel->save();
            }
        }
        
        session()->flash('commune', str_replace(" ","_",$value->commune)); //Necesario para ubicar comuna en el conjunto de tabs
        session()->flash('success', 'Actividad ejecutada para comuna de '.$request->commune.' se registra satisfactoriamente.');
        return redirect()->route('indicators.health_goals.show', [$law, $year, $indicator]);
    }

    public function updateIndValue($law, $year, $health_goal, Indicator $indicator, Value $value, Request $request)
    {
        $value->value = $request->has('value') ? 1 : 0;
        $value->save();

        if($request->hasFile('files')){
            foreach($request->file('files') as $file) {
                $filename = $file->getClientOriginalName();
                $fileModel = new AttachedFile();
                $fileModel->file = $file->store('ionline/indicators/health_goals/19813/'.$year,['disk' => 'gcs']);
                $fileModel->document_name = $filename;
                $fileModel->value_id = $value->id;
                $fileModel->save();
            }
        }
        
        session()->flash('commune', str_replace(" ","_",$value->commune)); //Necesario para ubicar comuna en el conjunto de tabs
        session()->flash('success', 'Actividad ejecutada para comuna de '.$request->commune.' se modifica satisfactoriamente.');
        return redirect()->route('indicators.health_goals.show', [$law, $year, $indicator]);
    }

    public function destroy_file(AttachedFile $attachedFile)
    {
        $attachedFile->delete();
        Storage::disk('gcs')->delete($attachedFile->file);

        session()->flash('success', 'Documento adjunto se eliminó satisfactoriamente.');
        return redirect()->back();
    }

    public function show_file(AttachedFile $attachedFile)
    {
        return Storage::disk('gcs')->response($attachedFile->file, $attachedFile->document_name);
    }
}
