<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Programmings\Programming;
use App\Programmings\ProgrammingItem;
use App\Models\Programmings\ReviewItem;
use App\Models\Programmings\Review;
use App\Programmings\Professional;
use App\Programmings\ProfessionalHour;
use App\Programmings\ProgrammingDay;

class ReviewItemController extends Controller
{
    public function index(Request $request)
    {
        $reviewItems = ReviewItem::with('user:id,name,fathers_family,mothers_family', 'reviewer:id,name,fathers_family,mothers_family')
                             ->where('programming_item_id', $request->programmingItem_id)
                             ->get();

        $programmingItem = ProgrammingItem::with('activityItem', 'programming')->find($request->programmingItem_id);
        
        $programmingDay = ProgrammingDay::where('programming_id',$programmingItem->programming_id)->first();

        $ph = ProfessionalHour::find($programmingItem->professional);
        if($ph){
            $professional = Professional::find($ph->professional_id);
            $professional = $professional->name ?? null;
        }
        else $professional = null;

        return view('programmings.reviewItems.index', compact('programmingItem', 'reviewItems', 'programmingDay', 'professional'));
    }

    public function store(Request $request)
    {
        //dd($request);
        $reviewItem = new ReviewItem($request->All());
        if($reviewItem->review == 'No hay observaciones. Actividad aceptada')
            $reviewItem->answer = $reviewItem->rectified = "SI";
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
        $reviewItem = ReviewItem::find($id);

        $reviewItem->fill($request->all());
        if($request->rectified){
            $reviewItem->rectified = $request->rectified;
            $reviewItem->rect_comments = $request->rect_comments;
            $reviewItem->updated_by = Auth()->user()->id;
        }

        $reviewItem->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
      $reviewItem = ReviewItem::where('id',$id)->first();
      $reviewItem->delete();

      session()->flash('success', 'El registro ha sido eliminado de este listado');
       return redirect()->back();
    }
}
