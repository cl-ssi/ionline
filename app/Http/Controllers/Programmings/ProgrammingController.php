<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Programmings\Programming;
use App\Models\Establishment;
use App\Models\Commune;
use App\Models\Programmings\CommuneFile;
use App\Models\Programmings\ActivityItem;
use App\Models\Programmings\ProfessionalHour;
use App\Models\Programmings\ProgrammingItem;
use App\Models\User;
use Illuminate\Support\Str;

class ProgrammingController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year + 1;
        $accessByCommune = null;
        $accessByEstablishments = null;
        if( auth()->user()->cannot('Reviews: edit') ){
            $last_year = Programming::latest()->first()->year;
            $accessByCommune = collect();
            $accessByEstablishments = collect();
            $last_programmings = Programming::with('establishment')->where('year', $last_year)->get();
            //El usuario tiene acceso por comunas y/o establecimientos?
            foreach($last_programmings as $programming){
                if(Str::contains($programming->access, auth()->user()->id)){
                    $accessByCommune->push($programming->establishment->commune_id);
                    $accessByEstablishments->push($programming->establishment_id);
                }
            }
        }

        $programmings = Programming::with('items.reviewItems', 'items.activityItem', 'establishment.commune', 'pendingItems', 'items.programming')
            ->where('year', $year)
            ->when($accessByEstablishments != null, function($q) use($accessByEstablishments){
                 $q->whereIn('establishment_id', $accessByEstablishments);
            })
            ->get();

        $total_tracers = ActivityItem::whereHas('program', function($q) use ($year) {
            return $q->where('year', $year);
        })->whereNotNull('int_code')->where('tracer', 'SI')->distinct('int_code')->count('int_code');

        $communeFiles = CommuneFile::with('commune')->where('year', $year)->where('status', 'active')
            ->when($accessByCommune != null, function($q) use($accessByCommune){
                $q->whereIn('commune_id', $accessByCommune);
            })
            ->get();

        return view('programmings.programmings.index', compact('programmings', 'request', 'year', 'total_tracers', 'communeFiles'));
    }

    public function create() 
    {   
        $establishments = Establishment::whereIn('type',['CESFAM','CGR']) // Solo centros de salud familiar
                                       ->OrderBy('name')->get(); 
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo funcionario Programación
        return view('programmings.programmings.create', compact('establishments', 'users'));
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

        return view('programmings.programmings.show', compact('programming', 'access_list', 'user', 'establishments', 'communes', 'users'));
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
