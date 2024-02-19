<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Programmings\Programming;
use App\Models\Programmings\ProgrammingItem;
use App\Models\Programmings\ReviewItem;
use App\Models\Programmings\Review;
use App\Models\Programmings\Professional;
use App\Models\Programmings\ProfessionalHour;
use App\Models\Programmings\ProgrammingDay;

class ReviewItemController extends Controller
{
    public function index(Request $request)
    {
        $reviewItems = ReviewItem::with('user:id,name,fathers_family,mothers_family', 'reviewer:id,name,fathers_family,mothers_family')
                             ->where('programming_item_id', $request->programmingItem_id)
                             ->get();

        $programmingItem = ProgrammingItem::with('activityItem', 'programming')->findOrFail($request->programmingItem_id);
        
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
        $reviewItem->user_id = auth()->user()->id;
        $reviewItem->save();

        session()->flash('success', 'Se ha creado una nueva observación para la actividad programada.');

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

        session()->flash('success', 'Se ha editado la observación satisfactoriamente.');

        return redirect()->back();
    }

    public function updateRect(Request $request,$id)
    {
        $reviewItem = ReviewItem::find($id);

        $reviewItem->fill($request->all());
        if($request->rectified){
            $reviewItem->rectified = $request->rectified;
            $reviewItem->rect_comments = $request->rect_comments;
            $reviewItem->updated_by = auth()->user()->id;
        }

        $reviewItem->save();

        session()->flash('success', 'Se ha rectificado correctamente la observación.');

        return redirect()->back();
    }

    public function destroy($id)
    {
      $reviewItem = ReviewItem::where('id',$id)->first();
      $reviewItem->delete();

      session()->flash('success', 'El registro ha sido eliminado de este listado');
       return redirect()->back();
    }

    public function acceptItems(Request $request)
    {
        // return $request;
        if($request->has('check_accept_item')){
            foreach($request->check_accept_item as $item){
                ReviewItem::create([
                    'review_id' => 1,
                    'review' => 'No hay observaciones. Actividad aceptada',
                    'answer' => 'SI',
                    'active' => 'SI',
                    'rectified' => 'SI',
                    'user_id' => auth()->user()->id,
                    'programming_item_id' => $item
                ]);
            }
        }

        session()->flash('success', 'Se ha creado una nueva observación de aceptación para las actividades seleccionadas');
        return redirect()->back();
    }
}
