<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
// use App\Models\Programmings\Programming;
use App\Models\Programmings\ProgrammingActivityItem;
use Illuminate\Http\Request;

class ProgrammingActivityItemController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        ProgrammingActivityItem::create([
            'programming_id' => $request->programming_id,
            'activity_item_id' => $request->pendingItemSelectedId,
            'requested_by' => auth()->id(),
            'observation' => $request->observation
        ]);
        // $programming = Programming::find($request->programming_id);
        // $programming->pendingItems()->attach($request->pendingItemSelectedId, ['requested_by' => auth()->id(), 'observation' => $request->observation]);
        session()->flash('info', 'Se agrega actividad pendiente satisfactoriamente.');
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
        session()->flash('info', 'Se elimina actividad pendiente satisfactoriamente.');
        return redirect()->back();
    }
}
