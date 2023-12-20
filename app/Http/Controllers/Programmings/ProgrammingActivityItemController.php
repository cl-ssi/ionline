<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Models\Programmings\Programming;
// use App\Models\Programmings\Programming;
use App\Models\Programmings\ProgrammingActivityItem;
use App\Models\Programmings\ProgrammingItem;
use App\Models\Programmings\ReviewItem;
use Illuminate\Http\Request;

class ProgrammingActivityItemController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        $year = Programming::find($request->programming_id)->year;
        if($year >= 2024){
            $programmingItem = new ProgrammingItem();
            $programmingItem->activity_type = !in_array($request->pendingItemSelectedId, ['Esporádicas', 'Designación']) ? 'Directa' : 'Indirecta';
            $programmingItem->activity_subtype = in_array($request->pendingItemSelectedId, ['Esporádicas', 'Designación']) ? $request->pendingItemSelectedId : null;
            $programmingItem->user_id = auth()->id();
            $programmingItem->activity_id = !in_array($request->pendingItemSelectedId, ['Esporádicas', 'Designación']) ? $request->pendingItemSelectedId : null;
            $programmingItem->programming_id = $request->programming_id;
            $programmingItem->save();

            $reviewItem = new ReviewItem();
            $reviewItem->review_id = 1;
            $reviewItem->review = 'Actividad pendiente por programar';
            $reviewItem->observation = $request->observation;
            $reviewItem->answer = $reviewItem->rectified = "NO";
            $reviewItem->active = "SI";
            $reviewItem->user_id = auth()->id();
            $reviewItem->programming_item_id = $programmingItem->id;
            $reviewItem->save();
        }else{
            ProgrammingActivityItem::create([
                'programming_id' => $request->programming_id,
                'activity_item_id' => $request->pendingItemSelectedId,
                'requested_by' => auth()->id(),
                'observation' => $request->observation
            ]);
        }
        session()->flash('info', 'Se agrega actividad pendiente por programar satisfactoriamente.');
        return redirect()->back();
    }

    public function update(Request $request, ProgrammingActivityItem $pendingitem)
    {
        $pendingitem->update(['observation' => $request->observation]);
        session()->flash('info', 'Se actualizó la observación de la actividad pendiente satisfactoriamente.');
        return redirect()->back();
    }

    public function destroy(ProgrammingActivityItem $pendingitem)
    {
        $pendingitem->delete();
        session()->flash('info', 'Se elimina actividad pendiente por eliminar satisfactoriamente.');
        return redirect()->back();
    }
}
