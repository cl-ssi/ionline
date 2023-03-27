<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Models\Indicators\HealthGoal;
use App\Models\Indicators\Indicator;
use App\Models\Indicators\Value;
use App\Programmings\Programming;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{

    public function show(Programming $programming)
    {
        $health_goal = HealthGoal::with('indicators')->where('name', 'LIKE', '%META VII%')->where('year', $programming->year)->firstOrFail();
        $activity = Indicator::findOrFail($health_goal->indicators->first()->id);
        $programming->load('establishment');
        $activity->load(['values' => function($q) use ($programming){
            $q->where('ind_values.establishment', $programming->establishment->type.' '.$programming->establishment->name)
              ->where('factor', 'denominador')->with('tasks');
        }]);
        // return $indicator;
        return view('programmings.participation.show', compact('programming', 'activity'));
    }

    public function create(Programming $programming, $indicatorId)
    {
        $programming->load('establishment');
        return view('programmings.participation.create', compact('programming', 'indicatorId'));
    }

    public function store(Programming $programming, Request $request)
    {
        $programming->load('establishment.commune');
        $result = Value::where('activity_name', 'like', $request->activity_name)->where('factor', 'denominador')
                                ->where('establishment', $programming->establishment->type.' '.$programming->establishment->name)
                                ->where('valueable_id', $request->indicator_id)->where('valueable_type', 'App\Models\Indicators\Indicator')->first();
        if($result){
            session()->flash('danger', 'El nombre de la actividad ya existe para el establecimiento.');
            return redirect()->back()->withInput();
        }

        Value::create([
            'activity_name' => $request->activity_name,
            'month' => 12,
            'factor' => 'denominador',
            'commune' => mb_strtoupper($programming->establishment->commune->name),
            'establishment' => $programming->establishment->type.' '.$programming->establishment->name,
            'value' => $request->value,
            'valueable_id' => $request->indicator_id,
            'valueable_type' => 'App\Models\Indicators\Indicator',
        ]);
        
        session()->flash('success', 'Se ha registrado la nueva actividad satisfactoriamente.');
        return redirect()->route('participation.show', $programming);
    }

    public function edit(Value $value, Programming $programming)
    {
        $programming->load('establishment');
        $value->load('tasks.reschedulings');
        return view('programmings.participation.edit', compact('programming', 'value'));
    }

    public function update(Value $value, Request $request)
    {
        $value->update($request->all());
        session()->flash('success', 'Se ha modificado satisfactoriamente el item de participación.');
        // return redirect()->route('participation.show', $request->programming_id);
        return redirect()->back();
    }

    public function destroy(Value $value)
    {
      $value->delete();

      session()->flash('success', 'La actividad ha sido eliminado satisfactoriamente');
      return redirect()->back();
    }
}
