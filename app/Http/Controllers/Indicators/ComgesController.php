<?php

namespace App\Http\Controllers\Indicators;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Indicators\Action;
use App\Indicators\Comges;
use App\User;
use App\Indicators\Indicator;

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
        $indicators->load(['actions' => function($q) use ($section){
            $q->where('ind_sections.number', $section)->with('values');
        }]);
        $corte = $comges->sections()->where('ind_sections.number', $section)->first();
        return view('indicators.comges.show', compact('comges', $corte !=null ? 'corte' : 'section', 'indicators'));
    }

    public function create($year)
    {
        $last_comges = Comges::where('year', $year)->orderBy('number', 'desc')->first();
        $last_number = $last_comges != null ? $last_comges->number + 1 : 1;
        $users = User::select('id', 'name', 'fathers_family', 'mothers_family')->orderBy('name')->get();
        return view('indicators.comges.create', compact('year', 'last_number', 'users'));
    }

    public function createAction($year, $comges, $section, Indicator $indicator)
    {
        // $corte = $indicator->sections()->where('ind_sections.number', $section)->first();
        // $last_action = $corte->actions->last();
        // $last_number = $last_action != null ? $last_action->number + 1 : 1;
        return view('indicators.comges.action.create', compact('section', 'indicator'))->with(['comges' => $indicator->comges]);
    }

    public function edit(Comges $comges)
    {
        $users = User::select('id', 'name', 'fathers_family', 'mothers_family')->orderBy('name')->get();
        $comges->load('indicators.sections');
        return view('indicators.comges.edit', compact('comges', 'users'));
    }

    public function editAction($year, $comges, $section, Indicator $indicator, Action $action)
    {
        $action->load('values', 'compliances');
        return view('indicators.comges.action.edit', compact('section', 'indicator', 'action'))->with(['comges' => $indicator->comges]);
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
                $new_indicator->comges_id = $comges->id;
                $new_indicator->save();

                foreach($indicator['cortes'] as $i => $weighting)
                    $new_indicator->sections()->create([
                        'number' => $i+1,
                        'weighting' => $weighting
                    ]);
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
            'denominator' => $request->get('denominator'),
            'denominator_source' => $request->has('numerator_source') ? $request->get('denominator_source') : null,
            'weighting' => $request->get('weighting'),
            'section_id' => $corte->id
        ]);

        $months_by_section = array(1 => array(1,2,3), 2 => array(4,5,6), 3 => array(7,8,9), 4 => array(10,11,12));

        if($request->has('numerator_month')){
            foreach($request->get('numerator_month') as $index => $value)
                $new_action->values()->create([
                    'month' => $months_by_section[$section][$index],
                    'factor' => 'numerador',
                    'value' => $value
                ]);
        }

        if($request->has('denominator_month')){
            foreach($request->get('denominator_month') as $index => $value)
                $new_action->values()->create([
                    'month' => $months_by_section[$section][$index],
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
        $action->numerator = $request->get('numerator');
        $action->numerator_source = $request->has('numerator_source') ? $request->get('numerator_source') : null;
        $action->denominator = $request->get('denominator');
        $action->denominator_source = $request->has('denominator_source') ? $request->get('denominator_source') : null;
        $action->save();

        $months_by_section = array(1 => array(1,2,3), 2 => array(4,5,6), 3 => array(7,8,9), 4 => array(10,11,12));

        if($request->has('numerator_month')){
            foreach($request->get('numerator_month') as $index => $value)
                $action->values()->updateOrCreate(
                    ['factor' => 'numerador', 'month' => $months_by_section[$section][$index]], 
                    ['value' => $value]
                );
        }

        if($request->has('denominator_month')){
            foreach($request->get('denominator_month') as $index => $value)
                $action->values()->updateOrCreate(
                    ['factor' => 'denominador', 'month' => $months_by_section[$section][$index]], 
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
}
