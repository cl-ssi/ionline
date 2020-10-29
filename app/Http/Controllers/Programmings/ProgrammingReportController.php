<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Programmings\Programming;
use App\Programmings\ProgrammingItem;
use App\Establishment;
use App\Models\Commune;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgrammingReportController extends Controller
{
    public function reportConsolidated(request $request) 
    {
        
        $year = $request->year;
        $option = $request->commune_filter;
        //dd($option);
        if($option == 'hospicio')
        {
            $establishment = [37, 10];
        }
        else if($option == 'iquique')
        {
            $establishment = [2, 5, 4, 3 ];
        }
        else if($option == 'pica')
        {
            $establishment = [26];
        }
        else if($option == 'huara')
        {
            $establishment = [20];
        }
        else if($option == 'pozoalmonte')
        {
            $establishment = [29];
        }
        else if($option == 'colchane')
        {
            $establishment = [17];
        }
        else if($option == 'camiña')
        {
            $establishment = [15];
        }
        else if($option == 'hectorreyno')
        {
            $establishment = [12];
        }
        else
        {
            $establishment = [37, 10];
        }

        $programmingitems = ProgrammingItem::select(
                                 't6.int_code'
                                ,'pro_programming_items.activity_name'
                                ,'pro_programming_items.cycle'
                                ,'pro_programming_items.action_type'
                                ,'pro_programming_items.def_target_population'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total') )
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                        ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->whereIn('T0.establishment_id',$establishment)
                        ->groupBy('t6.int_code','pro_programming_items.activity_name','pro_programming_items.cycle','pro_programming_items.action_type','pro_programming_items.def_target_population')
                        ->orderByRaw("CAST(t6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.cycle','ASC')
                        ->orderBy('pro_programming_items.action_type','ASC')
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();

        //dd($programmingitems);

        return view('programmings/reports/reportConsolidated')->withProgrammingItems($programmingitems);
    }

    public function reportConsolidatedSep(request $request) 
    {
        
        $year = $request->year;
        if(!$year)
        {
            $year = date("Y");
        }
        $option = $request->commune_filter;
        if($option == 'hospicio')
        {
            $establishment = [37, 10];
        }
        else if($option == 'iquique')
        {
            $establishment = [2, 5, 4, 3 ];
        }
        else if($option == 'pica')
        {
            $establishment = [26];
        }
        else if($option == 'huara')
        {
            $establishment = [20];
        }
        else if($option == 'pozoalmonte')
        {
            $establishment = [29];
        }
        else if($option == 'colchane')
        {
            $establishment = [17];
        }
        else if($option == 'camiña')
        {
            $establishment = [15];
        }
        else if($option == 'hectorreyno')
        {
            $establishment = [12];
        }
        else
        {
            $establishment = [37, 10];
        }

        $programmingitems = ProgrammingItem::select(
                                 't6.int_code'
                                ,'pro_programming_items.activity_name'
                                ,'pro_programming_items.cycle'
                                ,'pro_programming_items.action_type'
                                ,'pro_programming_items.def_target_population'
                                ,'pro_programming_items.def_target_population'
                                ,'T4.name AS professional'
                                , DB::raw('sum(pro_programming_items.activity_total) AS activity_total') )
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                        ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T6', 'pro_programming_items.activity_id', '=', 'T6.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->whereIn('T0.establishment_id',$establishment)
                        ->groupBy('t6.int_code','pro_programming_items.activity_name','pro_programming_items.cycle','pro_programming_items.action_type','pro_programming_items.def_target_population','T4.name')
                        ->orderByRaw("CAST(t6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.cycle','ASC')
                        ->orderBy('pro_programming_items.action_type','ASC')
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();

        //dd($programmingitems);

        return view('programmings/reports/reportConsolidatedSep')->withProgrammingItems($programmingitems);
    }
}
