<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProfAgenda\ActivityType;

class ActivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activityTypes = ActivityType::all();
        return view('prof_agenda.activity_types.index',compact('activityTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prof_agenda.activity_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $activityType = new ActivityType($request->All());
      $activityType->save();

      session()->flash('info', 'El tipo de actividad ha sido registrada.');
      return redirect()->route('prof_agenda.activity_types.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityType $activityType)
    {
        return view('prof_agenda.activity_types.edit', compact('activityType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityType $activityType)
    {
        $activityType->fill($request->all());
        $activityType->save();

        session()->flash('info', 'El tipo de actividad ha sido actualizada.');
        return redirect()->route('prof_agenda.activity_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityType $activityType)
    {
      $activityType->delete();
      session()->flash('success', 'El tipo de actividad ha sido eliminado.');
      return redirect()->route('prof_agenda.activity_types.index');
    }
}
