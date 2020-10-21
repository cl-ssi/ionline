<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Programming;
use App\Establishment;
use App\Commune;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ProgrammingController extends Controller
{
    public function index()
    {
        
        $year = '';
        if(Auth()->user()->id == '15683706' || Auth()->user()->id == '13641014' || Auth()->user()->id == '17011541' || Auth()->user()->id == '15287582')
        {
        
        $programmings = Programming::select(
                             'pro_programmings.id'
                            ,'pro_programmings.year'
                            ,'pro_programmings.user_id'
                            ,'pro_programmings.description'
                            ,'pro_programmings.created_at'
                            ,'T1.type AS establishment_type'
                            ,'T1.name AS establishment'
                            ,'T2.name AS commune'
                            ,'T3.name' 
                            ,'T3.fathers_family'
                            ,'T3.mothers_family')
                ->leftjoin('establishments AS T1', 'pro_programmings.establishment_id', '=', 'T1.id')
                ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                ->leftjoin('users AS T3', 'pro_programmings.user_id', '=', 'T3.id')
                ->Where('pro_programmings.year','LIKE','%'.$year.'%')
                ->orderBy('T2.name','ASC')->get();
        }
        else {
            $programmings = Programming::select(
                        'pro_programmings.id'
                        ,'pro_programmings.year'
                        ,'pro_programmings.user_id'
                        ,'pro_programmings.description'
                        ,'pro_programmings.created_at'
                        ,'T1.type AS establishment_type'
                        ,'T1.name AS establishment'
                        ,'T2.name AS commune'
                        ,'T3.name' 
                        ,'T3.fathers_family'
                        ,'T3.mothers_family')
            ->leftjoin('establishments AS T1', 'pro_programmings.establishment_id', '=', 'T1.id')
            ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
            ->leftjoin('users AS T3', 'pro_programmings.user_id', '=', 'T3.id')
            ->Where('pro_programmings.year','LIKE','%'.$year.'%')
            ->Where('pro_programmings.access','LIKE','%'.Auth()->user()->id.'%')
            ->orderBy('T2.name','ASC')->get();
        }
        
        return view('programmings/programmings/index')->withProgrammings($programmings);
    }

    public function create() 
    {
        $establishments = Establishment::whereIn('type',['CESFAM','CGR'])
                                       ->OrderBy('name')->get(); // Filtrar CENTROS
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        return view('programmings/programmings/create')->withEstablishments($establishments)->withUsers($users);
    }

    public function store(Request $request)
    {
        //dd($request);
        $programmingValid = Programming::where('establishment_id', $request->establishment)
                                  ->where('year', $request->date)
                                  ->first();
        if($programmingValid){
            session()->flash('warning', 'Ya se ha iniciado esta Programación Operativa anteriormente');
        }
        else {

            //dd($request);
            $programming = new Programming($request->All());
            $programming->year = $request->date; // date('Y', strtotime($request->date));
            $programming->description = $request->description;
            $programming->establishment_id = $request->establishment;
            $programming->user_id  = $request->user;
            $programming->access   = serialize($request->access);
        
            $programming->save();

            session()->flash('info', 'Se ha iniciado una nueva Programación Operativa');
        }

        return redirect()->back();
    }

    public function show(Programming $programming)
    {
        //dd($programming);
        $establishments = Establishment::whereIn('type',['CESFAM','CGR'])
                                       ->OrderBy('name')->get(); // Filtrar CENTROS
        $users = User::with('organizationalUnit')->where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        $access_list = unserialize($programming->access);
        $user = $programming->user;
        return view('programmings/programmings/show')->withProgramming($programming)->with('access_list', $access_list)->with('user', $user)->withEstablishments($establishments)->withUsers($users);
    }

    public function update(Request $request, Programming $programming)
    {
      //dd($request);
      $programming->fill($request->all());
      $programming->year = $request->date;
      $programming->user_id  = $request->user;
      $programming->access   = serialize($request->access);
      $programming->save();
      return redirect()->back();
    }

}
