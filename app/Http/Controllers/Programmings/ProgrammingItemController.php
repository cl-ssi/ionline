<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Programming;
use App\Programmings\ProgrammingItem;
use App\Establishment;
use App\Commune;

class ProgrammingItemController extends Controller
{
    public function index()
    {
        $programmingitems = ProgrammingItem::All()->SortBy('name');
        return view('programmings/programmingitems/index')->withProgrammingItems($programmingitems);
    }

    public function create()
    {
        $establishments = Establishment::where('type','CESFAM')->OrderBy('name')->get();
        $communes = Commune::All()->SortBy('name');
        return view('programmings/programmingitems/create')->withEstablishments($establishments)->withCommunes($communes);
    }

    public function store(Request $request)
    {
        //dd($request->All());
        $programming = new Programming($request->All());
        $programming->year = date('Y', strtotime($request->date));
        $programming->description = $request->description;
        $programming->establishment_id = $request->establishment;
        $programming->user_id = '16966444';
       
        $programming->save();

        session()->flash('info', 'Se ha iniciado una nueva Programación Operativa');

        return redirect()->back();
    }

}
