<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Models\Programmings\CommuneFile;
use Illuminate\Http\Request;
use App\Models\Programmings\Programming;
use App\Models\Programmings\TrainingItem;

class TrainingsItemController extends Controller
{
    public function index(Request $request)
    {
        $trainingItems = TrainingItem::where('programming_id',$request->commune_file_id)->OrderBy('linieamiento_estrategico')->get();
        $communeFile = CommuneFile::find($request->commune_file_id);
        $programming_status = Programming::where('year', $communeFile->year)->whereHas('establishment.commune', function($q) use ($communeFile){
            return $q->where('id', $communeFile->commune_id);
        })->first()->status;

        return view('programmings.trainingItems.index', compact('trainingItems', 'programming_status'));
    }

    public function create(Request $request)
    {
        $year = CommuneFile::find($request->commune_file_id)->year;
        return view('programmings.trainingItems.create', compact('year'));
    }

    public function store(Request $request)
    {
        //dd($request->All());
        $trainingItems = new TrainingItem($request->All());
        //$programming->year = date('Y', strtotime($request->date));
        //$programming->description = $request->description;
        //$programming->establishment_id = $request->establishment;
        $trainingItems->programming_id = $request->commune_file_id;
       
        $trainingItems->save();

        session()->flash('info', 'Se ha registrado el nuevo Item de Capacitación');

        return redirect()->back();
        //return redirect()->route('trainingItems', ['programming_id' => 1]);
    } 

    public function show(Request $request,$id)
    {
        $trainingItems = TrainingItem::with('communeFile')->find($id);
        // return $trainingItems;
        return view('programmings.trainingItems.show')->withtrainingItems($trainingItems);
    }

    public function destroy($id)
    {
      $trainingItem = TrainingItem::where('id',$id)->first();
      $trainingItem->delete();

      session()->flash('success', 'El registro ha sido eliminado de este listado');
       return redirect()->back();
    }

    public function update(Request $request, TrainingItem $trainingitem)
    {
        $trainingitem->fill($request->all());
        $trainingitem->save();
        session()->flash('success', 'El registro ha sido actualizado correctamente');
        return redirect()->back();
    }
}
