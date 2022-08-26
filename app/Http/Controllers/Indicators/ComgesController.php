<?php

namespace App\Http\Controllers\Indicators;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Indicators\Action;
use App\Indicators\Comges;
use App\User;
use App\Indicators\Indicator;
use App\Indicators\Rem;
use App\Indicators\Value;
use App\Models\Parameters\CutOffDate;
use Illuminate\Support\Facades\DB;

class ComgesController extends Controller
{
    public function index()
    {
        return view('indicators.comges.index');
    }

    public function list($year)
    {
        $comges = Comges::with('users')->where('year', $year)->orderBy('number')->get();
        return view('indicators.comges.list', compact('comges', 'year'));
    }

    public function show($year, $comges, $section)
    {
        $comges = Comges::where('year', $year)->where('number', $comges)->first();
        // Nos aseguramos que el comges existe y el corte consultado se encuentre entre 1 y 4
        if($comges == null || $section < 1 || $section > 4) abort(404);
        $comges->load('users');
        $indicators = $comges->indicators()->whereHas('sections', function($q) use ($section){
            $q->where('ind_sections.number', $section);
        })->get();
        $indicators->load(['users', 'actions' => function($q) use ($section){
            $q->where('ind_sections.number', $section)->with('values');
        }]);
        $corte = $comges->sections()->where('ind_sections.number', $section)->first();
        // $this->loadActionsWithRemSource($year, $comges->number, $section, $indicators);
        $this->loadValuesWithRemSource($year, $section, $indicators);
        // return $indicators;
        return view('indicators.comges.show', compact('comges', $corte !=null ? 'corte' : 'section', 'indicators'));
    }

    public function create($year)
    {
        // $last_comges = Comges::where('year', $year)->orderBy('number', 'desc')->first();
        // $last_number = $last_comges != null ? $last_comges->number + 1 : 1;
        $users = User::select('id', 'name', 'fathers_family', 'mothers_family')->orderBy('name')->get();
        // return view('indicators.comges.create', compact('year', 'last_number', 'users'));
        return view('indicators.comges.create', compact('year', 'users'));
    }

    public function createAction($year, $comges, $section, Indicator $indicator)
    {
        // $corte = $indicator->sections()->where('ind_sections.number', $section)->first();
        // $last_action = $corte->actions->last();
        // $last_number = $last_action != null ? $last_action->number + 1 : 1;
        $indicator->load('users');
        return view('indicators.comges.action.create', compact('section', 'indicator'))->with(['comges' => $indicator->indicatorable]);
    }

    public function edit(Comges $comges)
    {
        $users = User::select('id', 'name', 'fathers_family', 'mothers_family')->orderBy('name')->get();
        $comges->load('indicators.sections', 'indicators.users');
        return view('indicators.comges.edit', compact('comges', 'users'));
    }

    public function editAction($year, $comges, $section, Indicator $indicator, Action $action)
    {
        $indicator->load('users');
        $action->load('values', 'compliances');
        return view('indicators.comges.action.edit', compact('section', 'indicator', 'action'))->with(['comges' => $indicator->indicatorable]);
    }

    public function store($year, Request $request)
    {
        $comges = Comges::create([
            'number' => $request->get('number'),
            'name' => $request->get('name'),
            'year' => $year
        ]);
        $comges->save();
        
        foreach($request->get('referrer') as $i => $referrer_id)
            $comges->users()->attach($referrer_id, ['referrer_number' => $i+1]);

        if($request->has('indicator'))
            foreach($request->get('indicator') as $indicator){
                $new_indicator = new Indicator();
                $new_indicator->number = $indicator['number'];
                $new_indicator->name = $indicator['name'];
                $new_indicator->weighting_by_section = $indicator['weighting'];
                $new_indicator->numerator = $indicator['numerator'];
                $new_indicator->numerator_source = $indicator['numerator_source'];
                $new_indicator->denominator = $indicator['denominator'];
                $new_indicator->denominator_source = $indicator['denominator_source'];
                $new_indicator->indicatorable_id = $comges->id;
                $new_indicator->indicatorable_type = 'App\Indicators\Comges';
                $new_indicator->save();

                foreach($indicator['cortes'] as $i => $weighting)
                    $new_indicator->sections()->create([
                        'number' => $i+1,
                        'weighting' => $weighting
                    ]);

                foreach($indicator['referrers'] as $i => $referrer_id)
                    $new_indicator->users()->attach($referrer_id, ['referrer_number' => $i+1]);
            }

        return redirect()->route('indicators.comges.list', [$year])->with('success', 'Registro creado satisfactoriamente');
    }

    public function storeAction($year, Comges $comges, $section, Indicator $indicator, Request $request)
    {
        // return $request;
        $corte = $indicator->sections()->where('ind_sections.number', $section)->first();

        $new_action = $indicator->actions()->create([
            'number' => $request->get('number'),
            'name' => $request->get('name'),
            'verification_means' => $request->get('verification_means'),
            'target_type' => $request->get('target_type'),
            'numerator' => $request->get('numerator'),
            'numerator_source' => $request->has('numerator_source') ? $request->get('numerator_source') : null,
            'numerator_cods' => $request->has('numerator_cods') ? $request->get('numerator_cods') : null,
            'numerator_cols' => $request->has('numerator_cols') ? $request->get('numerator_cols') : null,
            'denominator' => $request->get('denominator'),
            'denominator_source' => $request->has('denominator_source') ? $request->get('denominator_source') : null,
            'denominator_cods' => $request->has('denominator_cods') ? $request->get('denominator_cods') : null,
            'denominator_cols' => $request->has('denominator_cols') ? $request->get('denominator_cols') : null,
            'weighting' => $request->get('weighting'),
            'section_id' => $corte->id,
            'is_accum' => $request->has('is_accum') ?? 0
        ]);

        //$months_by_section = array(1 => array(1,2,3), 2 => array(4,5,6), 3 => array(7,8,9), 4 => array(10,11,12));

        if($request->has('numerator_month')){
            foreach($request->get('numerator_month') as $index => $value)
                $new_action->values()->create([
                    // 'month' => $months_by_section[$section][$index],
                    'month' => $index + 1,
                    'factor' => 'numerador',
                    'value' => $value
                ]);
        }

        if($request->has('denominator_month')){
            foreach($request->get('denominator_month') as $index => $value)
                $new_action->values()->create([
                    // 'month' => $months_by_section[$section][$index],
                    'month' => $index + 1,
                    'factor' => 'denominador',
                    'value' => $value
                ]);
        }

        if($request->has('compliance_value')){
            foreach($request->get('compliance_value') as $index => $value)
                if($value != null)
                    $new_action->compliances()->create([
                        'left_result_value' => $request->get('left_result_value')[$index],
                        'left_result_operator' => $request->get('left_result_operator')[$index],
                        'right_result_value' => $request->get('right_result_value')[$index],
                        'right_result_operator' => $request->get('right_result_operator')[$index],
                        'compliance_value' => $value
                    ]);
        }

        return redirect()->route('indicators.comges.show', [$year, $comges->number, $section])->with('success', 'Registro creado satisfactoriamente');
    }

    public function update(Comges $comges, Request $request)
    {
        // return $request;
        $comges->name = $request->get('name');
        $comges->save();
        
        $comges->users()->detach();
        foreach($request->get('referrer') as $i => $referrer_id)
            $comges->users()->attach($referrer_id, ['referrer_number' => $i+1]);

        foreach($request->get('indicator') as $i => $indicator){
            $ind_updated = $comges->indicators()->updateOrCreate(['number' => $indicator['number']], [
                'name' => $indicator['name'],
                'weighting_by_section' => $indicator['weighting'],
                'numerator' => $indicator['numerator'],
                'numerator_source' => $indicator['numerator_source'],
                'denominator' => $indicator['denominator'],
                'denominator_source' => $indicator['denominator_source'],
            ]);

            foreach($indicator['cortes'] as $j => $weighting)
                $ind_updated->sections()->updateOrCreate(['number' => $j+1], [
                    'weighting' => $weighting
                ]);
            
            $ind_updated->users()->detach();
            foreach($indicator['referrers'] as $j => $referrer_id)
                $ind_updated->users()->attach($referrer_id, ['referrer_number' => $j+1]);
        }

        return redirect()->route('indicators.comges.list', [$comges->year])->with('success', 'Registro actualizado satisfactoriamente');
    }

    public function updateAction($year, Comges $comges, $section, Indicator $indicator, Action $action,  Request $request)
    {
        // return $request;
        $action->number = $request->get('number');
        $action->name = $request->get('name');
        $action->weighting = $request->get('weighting');
        $action->verification_means = $request->get('verification_means');
        $action->target_type = $request->get('target_type');
        $action->is_accum = $request->has('is_accum') ?? 0;
        $action->numerator = $request->get('numerator');
        $action->numerator_source = $request->has('numerator_source') ? $request->get('numerator_source') : null;
        $action->numerator_cods = $request->has('numerator_cods') ? $request->get('numerator_cods') : null;
        $action->numerator_cols = $request->has('numerator_cols') ? $request->get('numerator_cols') : null;
        $action->denominator = $request->get('denominator');
        $action->denominator_source = $request->has('denominator_source') ? $request->get('denominator_source') : null;
        $action->denominator_cods = $request->has('denominator_cods') ? $request->get('denominator_cods') : null;
        $action->denominator_cols = $request->has('denominator_cols') ? $request->get('denominator_cols') : null;
        $action->save();

        // $months_by_section = array(1 => array(1,2,3), 2 => array(4,5,6), 3 => array(7,8,9), 4 => array(10,11,12));

        if($request->has('numerator_month')){
            foreach($request->get('numerator_month') as $index => $value)
                $action->values()->updateOrCreate(
                    // ['factor' => 'numerador', 'month' => $months_by_section[$section][$index]], 
                    ['factor' => 'numerador', 'month' => $index + 1], 
                    ['value' => $value]
                );
        }

        if($request->has('denominator_month')){
            foreach($request->get('denominator_month') as $index => $value)
                $action->values()->updateOrCreate(
                    // ['factor' => 'denominador', 'month' => $months_by_section[$section][$index]], 
                    ['factor' => 'denominador', 'month' => $index + 1], 
                    ['value' => $value]
                );
        }

        $action->compliances()->delete();

        if($request->has('compliance_value')){
            foreach($request->get('compliance_value') as $index => $value)
                if($value != null)
                    $action->compliances()->create([
                        'left_result_value' => $request->get('left_result_value')[$index],
                        'left_result_operator' => $request->get('left_result_operator')[$index],
                        'right_result_value' => $request->get('right_result_value')[$index],
                        'right_result_operator' => $request->get('right_result_operator')[$index],
                        'compliance_value' => $value
                    ]);
        }

        return redirect()->route('indicators.comges.show', [$year, $comges->number, $section])->with('success', 'Registro actualizado satisfactoriamente');
    }

    // private function loadActionsWithRemSource($year, $comges, $section, $indicators)
    // {
    //     // Último mes según corte
    //     $last_month_section = [1 => 3, 2 => 6, 3 => 9, 4 => 12];
    //     // Se define un array con los códigos de prestación que pertenecen a una misma fuente independiente del factor
    //     $same_source_rows = ['07020130', '07020230', '07020330', '07020331', '07020332', '07024219', '07020500', '07020501',
    //                         '07020600', '07020601', '07020700', '07020800', '07020801', '07020900', '07020901', '07021000',
    //                         '07021001', '07021100', '07021101', '07021230', '07021300', '07021301', '07022000', '07022001',
    //                         '07021531', '07022132', '07022133', '07022134', '07021700', '07021800', '07021801', '07021900',
    //                         '07022130', '07022142', '07022143', '07022144', '07022135', '07022136', '07022137', '07022700',
    //                         '07022800', '07022900', '07021701', '07023100', '07023200', '07023201', '07023202', '07023203',
    //                         '07023700', '07023701', '07023702', '07023703', '07024000', '07024001', '07024200', '07030500',
    //                         '07024201', '07024202', '07030501', '07030502'];
    //     $actions_rem = [
    //         2020 => [ 
    //             1 => [
    //                 1 => [
    //                     // 'action' => [1,2,3,4], 'section' => [1,2,3,4], 
    //                     'numerator_source_col' => ['Col30', 'Col31'], 
    //                     'numerator_source_row' => $same_source_rows,
    //                     'denominator_source_col' => ['Col22', 'Col26'],
    //                     'denominator_source_row' => $same_source_rows ],
    //                 2 => [
    //                     // 'action' => [1,2,3,4], 'section' => [1,2,3,4],
    //                     'numerator_source_col' => ['Col37', 'Col38'],
    //                     'numerator_source_row' => $same_source_rows,
    //                     'denominator_source_col' => ['Col01'],
    //                     'denominator_source_row' => $same_source_rows ],
    //             ],
    //             3 => [
    //                 3 => [
    //                     // 'action' => [1,2,3,4], 'section' => [1,2,3,4], 
    //                     'numerator_source_col' => ['Col22', 'Col26'], 
    //                     'numerator_source_row' => $same_source_rows,
    //                     'denominator_source_col' => ['Col01'],
    //                     'denominator_source_row' => $same_source_rows ],
    //                 4 => [
    //                     // 'action' => [1,2,3,4], 'section' => [1,2,3,4], 
    //                     'numerator_source_col' => ['Col32', 'Col33'], 
    //                     'numerator_source_row' => $same_source_rows,
    //                     'denominator_source_col' => ['Col01', 'Col32', 'Col33'],
    //                     'denominator_source_row' => $same_source_rows ],
    //             ]
    //         ],
    //     ];

    //     foreach($indicators as $indicator){
    //         foreach($indicator->actions as $action){
    //             if($action->values->isEmpty() && isset($actions_rem[$year][$comges][$indicator->number])){
    //                 // generar consulta sql numerador
    //                 $cols = $rows = null;
    //                 foreach($actions_rem[$year][$comges][$indicator->number]['numerator_source_col'] as $col)
    //                     $cols .= (next($actions_rem[$year][$comges][$indicator->number]['numerator_source_col'])) ? 'ifnull('.$col.', 0) + ' : 'ifnull('.$col.', 0)';
                    
    //                 $rows = implode(', ', $actions_rem[$year][$comges][$indicator->number]['numerator_source_row']);

    //                 $sql = "SELECT e.Comuna, e.alias_estab, r.Mes, sum({$cols}) as numerador
    //                         FROM {$year}rems r
    //                         LEFT JOIN {$year}establecimientos e
    //                         ON r.IdEstablecimiento=e.Codigo
    //                         WHERE CodigoPrestacion in ({$rows}) AND e.Codigo = 102100 AND r.Mes <= $last_month_section[$section]
    //                         GROUP BY e.Comuna, e.alias_estab, r.Mes
    //                         ORDER BY e.Comuna, e.alias_estab, r.Mes";
    //                 $valores = DB::connection('mysql_rem')->select($sql);

    //                 $values = collect();
    //                 foreach($valores as $valor)
    //                     $values->add(new Value(['month' => $valor->Mes, 'factor' => 'numerador', 'value' => $valor->numerador]));
    //                 $action->setRelation('values', $values);

    //                 // generar consulta sql denominador
    //                 $cols = $rows = null;
    //                 foreach($actions_rem[$year][$comges][$indicator->number]['denominator_source_col'] as $col)
    //                     $cols .= (next($actions_rem[$year][$comges][$indicator->number]['denominator_source_col'])) ? 'ifnull('.$col.', 0) + ' : 'ifnull('.$col.', 0)';
                    
    //                 $rows = implode(', ', $actions_rem[$year][$comges][$indicator->number]['denominator_source_row']);

    //                 $sql = "SELECT e.Comuna, e.alias_estab, r.Mes, sum({$cols}) as denominador
    //                         FROM {$year}rems r
    //                         LEFT JOIN {$year}establecimientos e
    //                         ON r.IdEstablecimiento=e.Codigo
    //                         WHERE CodigoPrestacion in ({$rows}) AND e.Codigo = 102100 AND r.Mes <= $last_month_section[$section]
    //                         GROUP BY e.Comuna, e.alias_estab, r.Mes
    //                         ORDER BY e.Comuna, e.alias_estab, r.Mes";
    //                 $valores = DB::connection('mysql_rem')->select($sql);

    //                 foreach($valores as $valor)
    //                     $values->add(new Value(['month' => $valor->Mes, 'factor' => 'denominador', 'value' => $valor->denominador]));
    //                 $action->setRelation('values', $values);
    //             }
    //         }
    //     }

    //     // return $indicators;
    // }

    private function loadValuesWithRemSource($year, $section, $indicators)
    {
        // Último mes según corte
        $last_month_section = [0 => 0, 1 => 3, 2 => 6, 3 => 9, 4 => 12];
        $cut_off_date = null;

        foreach($indicators as $indicator){
            foreach($indicator->actions as $action){
                // REM mensual acumulado? extraer fecha a considerar según corte
                if(!$action->is_accum){
                    $cut_off_date = CutOffDate::where('year', $year)->where('number', $section)->first();
                }

                foreach(array('numerador', 'denominador') as $factor){
                    $factor_cods = $factor == 'numerador' ? $action->numerator_cods : $action->denominator_cods;
                    $factor_cols = $factor == 'numerador' ? $action->numerator_cols : $action->denominator_cols;

                    if($factor_cods != null && $factor_cols != null){
                        //procesamos los datos necesarios para todas consultas rem que se necesiten en las acciones
                        $cods_array = array_map('trim', explode(';', $factor_cods));
                        $cols_array = array_map('trim', explode(';', $factor_cols));

                        for($i = 0; $i < count($cods_array); $i++){
                            //procesamos los datos necesarios para las consultas rem
                            $cods = array_map('trim', explode(',', $cods_array[$i]));
                            $cols = array_map('trim', explode(',', $cols_array[$i]));
                            $raws = null;
                            foreach($cols as $col)
                                $raws .= next($cols) ? 'SUM(COALESCE('.$col.', 0)) + ' : 'SUM(COALESCE('.$col.', 0))';
                            $raws .= ' AS valor, Mes';
            
                            $result = Rem::year($year)->selectRaw($raws)
                                        ->when(!$action->is_accum, function($q) use ($last_month_section, $section, $cut_off_date){
                                            return $q->where('Mes', '>=', $last_month_section[$section - 1] + 1)
                                                     ->when($cut_off_date, function($q2) use ($cut_off_date){ 
                                                        return $q2->where('fechaIngreso', '<=', $cut_off_date->date->endOfDay());
                                                    });
                                        })
                                        ->where('Mes', '<=', $last_month_section[$section])->where('IdEstablecimiento', 102100)
                                        ->whereIn('CodigoPrestacion', $cods)->groupBy('Mes')->orderBy('Mes')->get();
            
                            foreach($result as $item)
                                $action->values->add(new Value(['month' => $item->Mes, 'factor' => $factor, 'value' => $item->valor]));
                        }
                    }
                }
            }
        }
    }
}
