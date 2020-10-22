<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Programmings\ActivityProgram;
use App\Establishment;
use App\Commune;

class ActivitiesProgramController extends Controller
{
    public function index()
    {
        $activitys = ActivityProgram::All()->SortBy('name');
        return view('programmings/activities/index')->withActivityPrograms($activitys);
    }

    public function create()
    {
        $establishments = Establishment::where('type','CESFAM')->OrderBy('name')->get();
        $communes = Commune::All()->SortBy('name');
        return view('programmings/activities/create')->withEstablishments($establishments)->withCommunes($communes);
    }

    public function store(Request $request)
    {
        //dd($request->All());
        $activityProgramValid = ActivityProgram::where('year', date('Y', strtotime($request->date)))
                                  ->first();
        if($activityProgramValid){
            session()->flash('warning', 'Ya se ha iniciado la parametrización para este año');
        }
        else {
            $activityProgram = new ActivityProgram($request->All());
            $activityProgram->year = date('Y', strtotime($request->date));
            $activityProgram->description = $request->description;
            $activityProgram->user_id = '16966444';
        
            $activityProgram->save();

            session()->flash('info', 'Se ha iniciado una nueva Parametrización de Actividades y Prestaciones');
        }

        return redirect()->back();
    }
}
