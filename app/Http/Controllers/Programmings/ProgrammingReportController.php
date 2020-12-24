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

use App\Models\Programmings\ReviewItem;

class ProgrammingReportController extends Controller
{
    public function reportConsolidated(request $request) 
    {
        
        $year = $request->year;
        if(!$year)
        {
            $year = date("Y");
        }
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
                        ->Where('T6.tracer','LIKE','SI')
                        ->whereIn('T0.establishment_id',$establishment)
                        ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.action_type')
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
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
                        ->Where('T6.tracer','LIKE','SI')
                        ->whereIn('T0.establishment_id',$establishment)
                        ->groupBy('T6.int_code','pro_programming_items.activity_name','pro_programming_items.cycle','pro_programming_items.action_type','pro_programming_items.def_target_population','T4.name')
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
                        ->orderBy('pro_programming_items.cycle','ASC')
                        ->orderBy('pro_programming_items.action_type','ASC')
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();

        //dd($programmingitems);

        return view('programmings/reports/reportConsolidatedSep')->withProgrammingItems($programmingitems);
    }


    public function reportObservation(request $request) 
    {
        
    

        // $reviewItems = ProgrammingItem::where('programming_id',5)->get();

        $reviewItems = ReviewItem::select(
                             'pro_review_items.id'
                            ,'pro_review_items.review'
                            ,'pro_review_items.observation'
                            ,'pro_review_items.answer'
                            ,'T1.activity_name'
                            ,'T1.cycle'
                            ,'T1.action_type'
                            ,'T1.def_target_population'
                            ,'T1.id AS id_programmingItems'
                            ,'T2.name AS name_rev'
                            ,'T2.fathers_family AS fathers_family_rev'
                            ,'T2.mothers_family AS mothers_family_rev'
                            ,'T6.int_code')
                        ->leftjoin('pro_programming_items AS T1', 'pro_review_items.programming_item_id', '=', 'T1.id')
                        ->leftjoin('users AS T2', 'pro_review_items.user_id', '=', 'T2.id')
                        ->leftjoin('pro_activity_items AS T6', 'T1.activity_id', '=', 'T6.id')
                        ->Where('pro_review_items.rectified','NO')
                        ->Where('pro_review_items.answer','NO')
                        ->Where('T1.programming_id',$request->programming_id) 
                        ->orderByRaw("CAST(T6.int_code as UNSIGNED) ASC")
                        ->get();


        //dd($reviewItems);

        return view('programmings/reports/reportObservation')->withReviewItems($reviewItems);
    }
}
