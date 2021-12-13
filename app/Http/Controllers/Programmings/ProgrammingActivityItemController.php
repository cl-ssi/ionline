<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Programmings\ActivityItem;
use App\Programmings\Programming;
use App\Programmings\ProgrammingActivityItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgrammingActivityItemController extends Controller
{
    // public function index(Programming $programming)
    // {
    //     $q = ActivityItem::whereHas('program', function($q) use ($programming) {
    //         return $q->where('year', $programming->year);
    //     });

    //     $programActivities = $q->get(['id', 'activity_name', 'tracer', 'def_target_population', 'professional']);

    //     $scheduledActivities = collect();
    //     foreach($programming->items as $item)
    //         $scheduledActivities->add(new ActivityItem(['id' => $item->activity_id, 'activity_name' => $item->activity_name]));
        
    //     $diff = $programActivities->diff($scheduledActivities);
    //     $pendingActivities = $diff->all();


    // }

    public function store(Request $request)
    {
        $programming = Programming::find($request->programming_id);
        $programming->pendingItems()->attach($request->pendingItemSelectedId, ['requested_by' => auth()->id(), 'observation' => $request->observation]);
        session()->flash('info', 'Se agrega actividad pendiente satisfactoriamente.');
        return redirect()->back();
    }

    public function update(Request $request, ProgrammingActivityItem $pendingitem)
    {
        $pendingitem->update(['observation' => $request->observation]);
        session()->flash('info', 'Se actualizó la observación de la actividad pendiente satisfactoriamente.');
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
