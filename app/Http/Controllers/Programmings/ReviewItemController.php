<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Programmings\Programming;
use App\Programmings\ProgrammingItem;
use App\Models\Programmings\ReviewItem;
use App\Models\Programmings\Review;

use App\Programmings\ProgrammingDay;

class ReviewItemController extends Controller
{
    public function index(Programming $programming,Request $request)
    {
        
        $reviews = ReviewItem::select(
                                        'pro_review_items.id'
                                       ,'pro_review_items.review_id'
                                       ,'pro_review_items.review'
                                       ,'pro_review_items.answer'
                                       ,'pro_review_items.observation'
                                       ,'pro_review_items.active'
                                       ,'pro_review_items.user_id'
                                       ,'pro_review_items.rectified'
                                       ,'pro_review_items.programming_item_id'
                                       ,'T1.name'
                                       ,'T1.fathers_family'
                                       ,'T1.mothers_family'
                                       ,'T2.name AS name_rev'
                                       ,'T2.fathers_family AS fathers_family_rev'
                                       ,'T2.mothers_family AS mothers_family_rev')
                               ->leftjoin('users AS T1', 'pro_review_items.user_id', '=', 'T1.id')
                               ->leftjoin('users AS T2', 'pro_review_items.updated_by', '=', 'T2.id')
                               ->where('pro_review_items.programming_item_id',$request->programmingItem_id)
                               ->orderBy('pro_review_items.id','ASC')
                               ->get();

    

        $programmingitems = ProgrammingItem::select(
                                                     'T0.description'
                                                    ,'T1.name AS establishment'
                                                    ,'T2.name AS commune'
                                                    ,'pro_programming_items.id'
                                                    ,'pro_programming_items.cycle'
                                                    ,'pro_programming_items.action_type'
                                                    ,'pro_programming_items.ministerial_program'
                                                    ,'pro_programming_items.activity_id'
                                                    ,'pro_programming_items.activity_name'
                                                    ,'pro_programming_items.def_target_population'
                                                    ,'pro_programming_items.source_population'
                                                    ,'pro_programming_items.cant_target_population'
                                                    ,'pro_programming_items.prevalence_rate'
                                                    ,'pro_programming_items.source_prevalence'
                                                    ,'pro_programming_items.coverture'
                                                    ,'pro_programming_items.population_attend'
                                                    ,'pro_programming_items.concentration'
                                                    ,'pro_programming_items.activity_total'
                                                    ,'pro_programming_items.activity_performance'
                                                    ,'pro_programming_items.hours_required_year'
                                                    ,'pro_programming_items.hours_required_day'
                                                    ,'pro_programming_items.direct_work_year'
                                                    ,'pro_programming_items.direct_work_hour'
                                                    ,'pro_programming_items.information_source'
                                                    ,'pro_programming_items.prap_financed'
                                                    ,'pro_programming_items.observation'
                                                    ,'T4.name AS professional'
                                                    ,'T3.value AS professional_value'
                                                    ,'T7.tracer AS tracer'
                                                    ,'T7.int_code AS tracer_number'
                                                    ,'pro_programming_items.programming_id')
                                            ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                                            ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                                            ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                                            ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                                            ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                                            ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                                            ->leftjoin('pro_activity_items AS T7', 'pro_programming_items.activity_id', '=', 'T7.id')
                                            ->Where('pro_programming_items.cycle','!=','TALLER')
                                            ->where('pro_programming_items.id',$request->programmingItem_id)
                                            ->orderBy('pro_programming_items.cycle','ASC')
                                            ->orderBy('pro_programming_items.action_type','ASC')
                                            ->orderBy('pro_programming_items.activity_name','ASC')
                                            ->first();
        
        $programmingDay = ProgrammingDay::where('programming_id',$programmingitems->programming_id)->first();

        //dd($reviews);

        return view('programmings/reviewItems/index')->withProgrammingItems($programmingitems)->withReviewItems($reviews)->withProgrammingDays($programmingDay);
    }

    public function store(Request $request)
    {
        //dd($request);
        $reviewItem = new ReviewItem($request->All());
        $reviewItem->review_id = 1;
        $reviewItem->user_id = Auth()->user()->id;
        $reviewItem->save();
        return redirect()->back();
    }

    public function update(Request $request,$id)
    {
       // DD($request);

        $reviewItem = ReviewItem::find($id);

        $reviewItem->fill($request->all());
        if($request->answer){
            $reviewItem->answer = $request->answer;
        }
        if($request->observation){
            $reviewItem->observation = $request->observation;
        }

        $reviewItem->save();

        return redirect()->back();
    }

    public function updateRect(Request $request,$id)
    {
       // DD($request);

        $reviewItem = ReviewItem::find($id);

        $reviewItem->fill($request->all());
        if($request->rectified){
            $reviewItem->rectified = $request->rectified;
            $reviewItem->updated_by = Auth()->user()->id;
        }

        $reviewItem->save();

        return redirect()->back();
    }
}
