<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Programmings\Programming;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgrammingActivityItemController extends Controller
{
    public function store(Request $request)
    {
        $programming = Programming::find($request->programming_id);
        $programming->pendingItems()->attach($request->pendingItemSelectedId, ['requested_by' => auth()->id(), 'observation' => $request->observation]);
        session()->flash('info', 'Se agrega actividad pendiente satisfactoriamente.');
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $programming = Programming::findOrFail($request->programming_id);
        $programming->pendingItems()->updateExistingPivot($id, ['deleted_at' => Carbon::now()]);
        session()->flash('info', 'Se elimina actividad pendiente satisfactoriamente.');
        return redirect()->back();
    }
}
