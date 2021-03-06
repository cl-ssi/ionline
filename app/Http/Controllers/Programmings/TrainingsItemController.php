<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Programming;
use App\Programmings\TrainingItem;

class TrainingsItemController extends Controller
{
    public function index(Request $request)
    {
        $trainingItems = TrainingItem::where('programming_id',$request->commune_file_id)->OrderBy('linieamiento_estrategico')->get();
        return view('programmings/trainingItems/index')->withtrainingItems($trainingItems);
    }

    public function create(Request $request)
    {
        
        $trainingItems = TrainingItem::All()->SortBy('name');
        return view('programmings/trainingItems/create')->withEstablishments($trainingItems);
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
        $trainingItems = TrainingItem::where('id',$id)->first();
        //dd($trainingItems);
        return view('programmings/trainingItems/show')->withtrainingItems($trainingItems);
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
