<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Programmings\Programming;
use App\Models\Programmings\ProgrammingItem;
use App\Models\Programmings\ProfessionalHour;
use App\Models\Establishment;
use App\Models\Commune;
use App\Models\Programmings\ActivityItem;
use App\Models\User;
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
        // $option = $request->commune_filter ?? 'hospicio';
        $establishments = Programming::with('establishment:id,name,type')->where('year', $year)->get()->pluck('establishment');
        $options = $request->establishment_filter ?? [$establishments->first()->id];

        // $hospicio = $year >= 2024 ? [37, 10, 12] : [37, 10];
        // $establishment = array('hospicio' => $hospicio, 'iquique' => [2, 5, 4, 3], 'pica' => [26], 'huara' => [20], 'pozoalmonte' => [29], 'colchane' => [17], 'camiña' => [15], 'hectorreyno' => [12]);

        // $programmingItems = ProgrammingItem::select(
        //                          'T6.int_code'
        //                         ,'pro_programming_items.activity_name'
        //                         // ,'pro_programming_items.action_type' //2023
        //                         , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
        //                         , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments'))
        //                 ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
        //                 ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
        //                 ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
        //                 ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
        //                 ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
        //                 ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
        //                 ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
        //                 ->Where('T0.year','LIKE','%'.$year.'%')
        //                 ->Where('T6.tracer','LIKE', $isTracer)
        //                 ->WhereNotNull('T6.int_code')
        //                 ->whereIn('T0.establishment_id',$establishment[$option])
        //                 ->where('pro_programming_items.activity_type', 'Directa')
        //                 // ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.action_type') // 2023
        //                 ->groupBy('T6.int_code','pro_programming_items.activity_name')
        //                 ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
        //                 // ->orderBy('pro_programming_items.action_type','ASC') // 2023
        //                 ->orderBy('pro_programming_items.activity_name','ASC')
        //                 ->get();

        $programmingItems = ProgrammingItem::select(
                                 'T6.int_code'
                                ,'pro_programming_items.activity_name'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
                                , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments'))
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->Where('T6.tracer','LIKE', $isTracer)
                        ->when($isTracer == 'SI', fn($q) => $q->WhereNotNull('T6.int_code'))
                        ->whereIn('T0.establishment_id',$options)
                        ->where('pro_programming_items.activity_type', 'Directa')
                        ->groupBy('T6.int_code','pro_programming_items.activity_name')
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();

        return view('programmings/reports/reportConsolidated', compact('programmingItems', 'year', 'options', 'isTracer', 'establishments'));
    }

    public function reportConsolidatedSep(request $request) 
    {
        $year = $request->year ?? date("Y");
        $isTracer = $request->isTracer ?? 'SI';
        // $option = $request->commune_filter ?? 'hospicio';
        // $establishment = array('hospicio' => [37, 10], 'iquique' => [2, 5, 4, 3], 'pica' => [26], 'huara' => [20], 'pozoalmonte' => [29], 'colchane' => [17], 'camiña' => [15], 'hectorreyno' => [12]);
        $establishments = Programming::with('establishment:id,name,type')->where('year', $year)->get()->pluck('establishment');
        $options = $request->establishment_filter ?? [$establishments->first()->id];
        $cycles = ActivityItem::whereHas('program', fn($q) => $q->where('year', $year) )->get()->pluck('vital_cycle')->unique();
        $cycle_selected = $request->cycle_filter ?? [];

        // $programmingItems = ProgrammingItem::select(
        //                          'T6.int_code'
        //                         ,'pro_programming_items.activity_name'
        //                         ,'pro_programming_items.cycle'
        //                         ,'pro_programming_items.action_type'
        //                         ,'pro_programming_items.def_target_population'
        //                         ,'pro_programming_items.def_target_population'
        //                         ,'T4.name AS professional'
        //                         , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
        //                         , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments') )
        //                 ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
        //                 ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
        //                 ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
        //                 ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
        //                 ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
        //                 ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
        //                 ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
        //                 ->Where('T0.year','LIKE','%'.$year.'%')
        //                 ->Where('T6.tracer','LIKE', $isTracer)
        //                 ->whereIn('T0.establishment_id',$options)
        //                 ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.cycle','pro_programming_items.action_type','pro_programming_items.def_target_population','T4.name')
        //                 ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
        //                 ->orderBy('pro_programming_items.cycle','ASC')
        //                 ->orderBy('pro_programming_items.action_type','ASC')
        //                 ->orderBy('pro_programming_items.activity_name','ASC')
        //                 ->get();

        $programmingItems = ProgrammingItem::select(
                                 'T6.int_code'
                                ,'T6.activity_name'
                                ,'T6.vital_cycle'
                                // ,'T4.name AS professional'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
                                , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments') )
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        // ->leftjoin('pro_programming_item_pro_hour AS T2','T2.id', '=', 'pro_programming_items.professional')
                        // ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        // ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        // ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->Where('T6.tracer','LIKE', $isTracer)
                        ->when($isTracer == 'SI', fn($q) => $q->WhereNotNull('T6.int_code'))
                        ->when(!empty($cycle_selected), fn($q) => $q->whereIn('pro_programming_items.cycle', $cycle_selected))
                        ->whereIn('T0.establishment_id',$options)
                        ->where('pro_programming_items.activity_type', 'Directa')
                        ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.cycle')
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.cycle','ASC')
                        ->get();

        return view('programmings/reports/reportConsolidatedSep', compact('programmingItems', 'year', 'options', 'isTracer', 'establishments', 'cycles', 'cycle_selected'));
    }

    public function reportConsolidatedSporadic(request $request) 
    {
        $year = $request->year ?? date("Y");
        $programmings = Programming::with('establishment:id,name,type')->where('year', $year)->get();
        $establishments = $programmings->pluck('establishment');
        $options = $request->establishment_filter ?? [$establishments->first()->id];
        $categorySelected = $request->activity_category ?? [];

        $programmingItems = ProgrammingItem::select(
                                 'pro_programming_items.activity_category'
                                // ,'T4.name AS professional'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total')
                                , DB::raw('GROUP_CONCAT(DISTINCT T1.name) AS establishments') )
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        // ->leftjoin('pro_programming_item_pro_hour AS T2','T2.id', '=', 'pro_programming_items.professional')
                        // ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        // ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        // ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->when(!empty($categorySelected), fn($q) => $q->whereIn('pro_programming_items.activity_category', $categorySelected))
                        ->whereIn('T0.establishment_id',$options)
                        ->where('pro_programming_items.activity_type', 'Indirecta')
                        ->where('pro_programming_items.activity_subtype', 'Esporádicas')
                        ->groupBy('pro_programming_items.activity_category')
                        ->orderBy('pro_programming_items.activity_category','ASC')
                        ->get();

        return view('programmings/reports/reportConsolidatedSporadic', compact('programmingItems', 'year', 'options', 'establishments', 'categorySelected'));
    }


    public function reportObservation(request $request) 
    {
        $reviewItems = ReviewItem::with('programItem.activityItem', 'user:id,name,fathers_family,mothers_family')
                                 ->Where('rectified','NO')
                                 ->Where('answer','NO')
                                 ->whereHas('programItem', function($q) use ($request){ 
                                    return $q->where('programming_id', $request->programming_id); 
                                 })->orderBy('id')->get();

        $pendingItems = ProgrammingActivityItem::with('activityItem', 'requestedBy')->where('programming_id', $request->programming_id)->get();
        $programming = Programming::find($request->programming_id);

        return view('programmings/reports/reportObservation', compact('reviewItems', 'pendingItems', 'programming'));
    }

    public function reportUsers(request $request)
    {
        $commune = $request->commune;
        $role = $request->role ?? 'Revisor';

        /**
         * Roles disponibles
         * ========================================
         * Programación Numérica: Administrador (Administrativo)
         * Programación Numérica: Revisor ( Revisor )
         * Programación Numérica: Usuario Básico ( Establecimiento )
         * Programación Numérica: Usuario Comunal ( Comunal )
         * Programación Numérica: Capacitación ( Capacitación )
         */

        switch($request->role){
            case 'Administrativo':
                $role_name = 'Programación Numérica: Administrador';
                break;
            case 'Revisor':
                $role_name = 'Programación Numérica: Revisor';
                break;
            case 'Establecimiento':
                $role_name = 'Programación Numérica: Usuario Básico';
                break;
            case 'Comunal':
                $role_name = 'Programación Numérica: Usuario Comunal';
                break;
            case 'Capacitacion':
                $role_name = 'Programación Numérica: Capacitación';
                break;
            default:
                $role_name = 'Programación Numérica: Revisor';
        }

        // Get all users with role
        $users = User::role($role_name)->orderBy('name')->get();

        // dd($users);

        // if($role == 'Training'){ //Perfil de capacitación
        //     $users = User::doesntHave('roles')
        //         ->permission('Programming: view')
        //         ->permission('TrainingItem: view')
        //         ->permission('TrainingItem: delete')
        //         ->orderBy('name')
        //         ->get();
        // }else{ // otros perfiles
            
        //     $excludedPermissions = [
        //         'Programming: view',
        //         'TrainingItem: view',
        //         'TrainingItem: delete'
        //     ];
        //     $users = User::whereHas('permissions', function ($query) use ($excludedPermissions) {
        //         $query->where('name', 'like', 'Programming:%')
        //               ->whereNotIn('name', $excludedPermissions);
        //     })->orderBy('name')->get();
        // }

        // buscar programaciones numericas por utimo año y segun comuna de ser necesario
        $last_year = Programming::max('year');

        $last_programmings = Programming::with($commune != null ? ['establishment' => function($q) use ($commune) {
            return $q->where('commune_id', $commune);
        }] : 'establishment')->where('year', $last_year)
        ->when($commune != null, function($query) use($commune) {
            return $query->whereHas('establishment', function ($query) use($commune) {
                return $query->where('commune_id', $commune);
            });
        })->get();
        
        // Recorrer usuarios encontrados con cada programación numérica de comuna para determinar a qué establecimientos tiene acceso
        $users = $users->map(function($user) use ($last_programmings) {
            $user->accessByEstablishments = $last_programmings->filter(function($programming) use ($user) {
                return Str::contains($programming->access, $user->id);
            })->pluck('establishment.official_name');
        
            return $user;
        });
        
        // Filtrar usuarios que solo tengan acceso a algún establecimiento según comuna seleccionada
        if ($commune != null) {
            $users = $users->filter(function($user) {
                return !$user->accessByEstablishments->isEmpty();
            });
        }

        // return $users;

        return view('programmings/reports/reportUsers', compact('users', 'role', 'commune'));
    }

    public function reportTotalRrhh(Request $request)
    {
        $last_year = Programming::latest()->first()->year;
        $year = $request->year ?? $last_year;
        $establishments = collect();
        $programming = $professionalHours = $establishment_id = null;
        /** Reemplazo de rol Programming Comunal */
        if( auth()->user()->can('Reviews: rectify') AND auth()->user()->can('Programming: report') ){
            $last_programmings = Programming::with('establishment:id,type,name')->where('year', $last_year)->get();
            //El usuario tiene acceso por establecimientos?
            foreach($last_programmings as $programming){
                if(Str::contains($programming->access, auth()->user()->id))
                    $establishments->push($programming->establishment);
            }

            $programmings = Programming::with('establishment:id,type,name')
                ->where('year', $year)
                ->when($establishments != null, function($q) use($establishments){
                    $q->whereIn('establishment_id', $establishments->pluck('id')->toArray());
                })
                ->get();
        }elseif( auth()->user()->can('Reviews: edit') AND auth()->user()->can('Programming: report') ){
            $programmings = Programming::with('establishment:id,type,name')->where('year', $year)->get();
            foreach($programmings as $programming)
                $establishments->push($programming->establishment);
        }else{
            session()->flash('warning', 'Estimado Usuario/a: no tiene los permisos para acceso a los reportes.');
            return redirect()->back();
        }

        if($programmings->isEmpty()){
            session()->flash('warning', 'Estimado Usuario/a: no existe programación numérica para el año seleccionado.');
            return redirect()->back();
        }
        // return $establishments;
        $establishment_id = $request->has('establishment_id') ? $request->establishment_id : $establishments->first()->id;
        if(count($request->all()) > 0){
            $programming = Programming::where('year', $year)->where('establishment_id', $establishment_id)->first();
            $professionalHours = ProfessionalHour::select(  
                'pro_professional_hours.id'
                ,'pro_professional_hours.professional_id'
                ,'pro_professional_hours.programming_id'
                ,'pro_professional_hours.value'
                ,'T1.alias')
            ->leftjoin('pro_professionals AS T1', 'pro_professional_hours.professional_id', '=', 'T1.id')
            ->Where('programming_id',$programming->id)
            ->orderBy('T1.alias','ASC')
            ->get();

            $programming->load('items.professionalHours');
            // return $programming;
        }

        return view('programmings.reports.reportTotalRrhh', compact('programming', 'professionalHours', 'establishments', 'establishment_id', 'year'));
    }
}
