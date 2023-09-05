<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Programmings\Programming;
use App\Models\Programmings\ProgrammingItem;
use App\Models\Establishment;
use App\Models\Commune;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Programmings\ReviewItem;
use App\Models\Programmings\ProgrammingActivityItem;

class ProgrammingReportController extends Controller
{
    public function reportConsolidated(request $request) 
    {
        
        $year = $request->year ?? date("Y");
        $isTracer = $request->isTracer ?? 'SI';
        $option = $request->commune_filter ?? 'hospicio';
        $establishment = array('hospicio' => [37, 10], 'iquique' => [2, 5, 4, 3], 'pica' => [26], 'huara' => [20], 'pozoalmonte' => [29], 'colchane' => [17], 'camiña' => [15], 'hectorreyno' => [12]);

        $programmingItems = ProgrammingItem::select(
                                 'T6.int_code'
                                ,'pro_programming_items.activity_name'
                                ,'pro_programming_items.action_type'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
                                , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments'))
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                        ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->Where('T6.tracer','LIKE', $isTracer)
                        ->whereIn('T0.establishment_id',$establishment[$option])
                        ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.action_type')
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.action_type','ASC')
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();

        return view('programmings/reports/reportConsolidated', compact('programmingItems', 'year', 'option', 'isTracer'));
    }

    public function reportConsolidatedSep(request $request) 
    {
        $year = $request->year ?? date("Y");
        $isTracer = $request->isTracer ?? 'SI';
        $option = $request->commune_filter ?? 'hospicio';
        $establishment = array('hospicio' => [37, 10], 'iquique' => [2, 5, 4, 3], 'pica' => [26], 'huara' => [20], 'pozoalmonte' => [29], 'colchane' => [17], 'camiña' => [15], 'hectorreyno' => [12]);

        $programmingItems = ProgrammingItem::select(
                                 'T6.int_code'
                                ,'pro_programming_items.activity_name'
                                ,'pro_programming_items.cycle'
                                ,'pro_programming_items.action_type'
                                ,'pro_programming_items.def_target_population'
                                ,'pro_programming_items.def_target_population'
                                ,'T4.name AS professional'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
                                , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments') )
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                        ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->Where('T6.tracer','LIKE', $isTracer)
                        ->whereIn('T0.establishment_id',$establishment[$option])
                        ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.cycle','pro_programming_items.action_type','pro_programming_items.def_target_population','T4.name')
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.cycle','ASC')
                        ->orderBy('pro_programming_items.action_type','ASC')
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();

        return view('programmings/reports/reportConsolidatedSep', compact('programmingItems', 'year', 'option', 'isTracer'));
    }


    public function reportObservation(request $request) 
    {
        $reviewItems = ReviewItem::with('programItem.activityItem', 'user:id,name,fathers_family,mothers_family')
                                 ->Where('rectified','NO')
                                 ->Where('answer','NO')
                                 ->whereHas('programItem', function($q) use ($request){ 
                                    return $q->where('programming_id', $request->programming_id); 
                                 })->orderBy('id')->get();

        $pendingItems = ProgrammingActivityItem::with('programming', 'activityItem', 'requestedBy')->where('programming_id', $request->programming_id)->get();

        return view('programmings/reports/reportObservation', compact('reviewItems', 'pendingItems'));
    }

    public function reportUsers(request $request)
    {
        $commune = $request->commune;
        $role = $request->role ?? 'Review';
        if($role == 'Training'){ //Perfil de capacitación
            $users = User::doesntHave('roles')->permission('Programming: view')->permission('TrainingItem: view')->permission('TrainingItem: delete')->orderBy('name')->get();
        }else{ // otros perfiles
            $users = User::role('Programming: '. $role)->orderBy('name')->get();
        }

        // buscar programaciones numericas por utimo año y segun comuna de ser necesario
        $last_year = Programming::latest()->first()->year;
        $last_programmings = Programming::with($commune != null ? ['establishment' => function($q) use ($commune) {
            return $q->where('commune_id', $commune);
        }] : 'establishment')->where('year', $last_year)
        ->when($commune != null, function($query) use($commune) {
            return $query->whereHas('establishment', function ($query) use($commune) {
                return $query->where('commune_id', $commune);
            });
        })->get();

        // recorrer usuarios encontrados con cada programacion numerica de comuna para determinar que establecimientos tiene acceso
        foreach($users as $user){
            // $user->accessByCommune = collect();
            $user->accessByEstablishments = collect();
            //El usuario tiene acceso por comunas y/o establecimientos?
            foreach($last_programmings as $programming){
                if(Str::contains($programming->access, $user->id)){
                    // $user->accessByCommune->push($programming->establishment->commune_id);
                    $user->accessByEstablishments->push($programming->establishment->official_name);
                }
            }
        }

        // filtrar usuarios que solo tengan acceso a algun establecimiento segun comuna seleccionada
        if($commune != null){
            foreach ($users as $key => $user)
                if($user->accessByEstablishments->isEmpty())
                    unset($users[$key]);
        }

        // return $users;

        return view('programmings/reports/reportUsers', compact('users', 'role', 'commune'));
    }
}
