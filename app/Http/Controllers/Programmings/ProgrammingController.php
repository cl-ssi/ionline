<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Programmings\Programming;
use App\Establishment;
use App\Models\Commune;
use App\Programmings\ActivityItem;
use App\User;

class ProgrammingController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year + 1;
        $programmings = Programming::with('items.reviewItems', 'items.activityItem')
            ->where('year', $year)
            ->when(Auth()->user()->hasAllRoles('Programming: Review') == False && Auth()->user()->hasAllRoles('Programming: Admin') == False, function($q){
                $q->Where('status','=','active')->Where('access','LIKE','%'.Auth()->user()->id.'%');
            })
            ->get();
            
        $communes = Commune::where('name', $request->name)->get();

        $total_tracers = ActivityItem::whereHas('program', function($q) use ($year) {
            return $q->where('year', $year);
        })->whereNotNull('int_code')->distinct('int_code')->count('int_code');

        return view('programmings/programmings/index', compact('programmings', 'request', 'communes', 'year', 'total_tracers'));
    }

    public function create() 
    {   
        $establishments = Establishment::whereIn('type',['CESFAM','CGR']) // Solo centros de salud familiar
                                       ->OrderBy('name')->get(); 
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo funcionario Programación
        return view('programmings/programmings/create', compact('establishments', 'users'));
    }

    public function store(Request $request)
    {
        $programmingValid = Programming::where('establishment_id', $request->establishment)
                                       ->where('year', $request->date)
                                       ->first();
        if($programmingValid){
            session()->flash('warning', 'Ya se ha iniciado esta Programación Operativa anteriormente');
        }
        else {
            $programming  = new Programming($request->All());
            $programming->year = $request->date;
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
        $establishments = Establishment::whereIn('type',['CESFAM','CGR'])
                                       ->OrderBy('name')->get();
        $communes = Commune::where('name')->get();

        $users = User::with('organizationalUnit')->where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        $access_list = unserialize($programming->access);
        $user = $programming->user;

        return view('programmings/programmings/show', compact('programming', 'access_list', 'user', 'establishments', 'communes', 'users'));
    }

    public function update(Request $request, Programming $programming)
    {
        $programming->fill($request->all());
        $programming->year = $request->date;
        $programming->user_id  = $request->user;
        $programming->access   = serialize($request->access);
        $programming->save();
        
        return redirect()->back();
    }

    public function updateStatus(Request $request,$id)
    {
        $programming = Programming::find($id);

        $programming->fill($request->all());
        if($request->status){
            $programming->status = $request->status;
        }
        $programming->save();

        return redirect()->back();
    }
}
