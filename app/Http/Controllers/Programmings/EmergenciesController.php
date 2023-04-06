<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Models\Programmings\Emergency;
use App\Models\Programmings\Programming;
use Illuminate\Http\Request;

class EmergenciesController extends Controller
{
    public function show(Programming $programming)
    {
        $programming->load('emergencies', 'establishment');
        $emergencies = $programming->emergencies->sortByDesc(function($q){
            return $q->factor;
        })->values()->all();

        return view('programmings.emergencies.show', compact('programming', 'emergencies'));
    }

    public function create(Programming $programming)
    {
        $programming->load('establishment');
        $categories = Emergency::getDangerList();
        return view('programmings.emergencies.create', compact('programming', 'categories'));
    }

    public function store(Request $request, Programming $programming)
    {
        $programming->emergencies()->save(new Emergency($request->all()));
        session()->flash('success', 'Se ha registrado satisfactoriamente el nuevo item de emergencias y desastre.');
        return redirect()->route('emergencies.show', $programming);
    }

    public function edit(Emergency $emergency)
    {
        $programming = Programming::with('establishment')->find($emergency->programming_id);
        $categories = $emergency->getDangerList();
        return view('programmings.emergencies.edit', compact('programming', 'emergency', 'categories'));
    }

    public function update(Emergency $emergency, Request $request)
    {
        $emergency->update($request->all());
        session()->flash('success', 'Se ha modificado satisfactoriamente el item de emergencias y desastre.');
        return redirect()->route('emergencies.show', $emergency->programming_id);
    }

    public function destroy(Emergency $emergency)
    {
      $emergency->delete();

      session()->flash('success', 'El item de emergencias y desastre ha sido eliminado satisfactoriamente');
      return redirect()->back();
    }
}
