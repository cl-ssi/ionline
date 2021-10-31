<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Programming;
use App\Programmings\ProgrammingItem;
use App\Programmings\ProfessionalHour;
use App\Programmings\ProgrammingDay;
use App\Programmings\ActivityItem;
use App\Models\Programmings\ReviewItem;
use App\Programmings\ActivityProgram;

class ProgrammingItemController extends Controller
{
    public function index(Request $request)
    {
        $listTracer = $request->tracer_number;

        $programming = Programming::whereId($request->programming_id)
            ->when(empty($listTracer), function ($q){
                return $q->with('items.reviewItems', 'items.activityItem', 'items.professionalHour.professional', 'establishment');
            })
            ->when(!empty($listTracer), function ($q) use ($listTracer) {
                return $q->whereHas('items.activityItem', $filter = function($q) use ($listTracer){
                    return $q->Wherein('int_code', $listTracer);
                })->with(['items.reviewItems', 'items.activityItem' => $filter, 'items.professionalHour.professional', 'establishment'])->get();
             })
            ->first();

        $tracerNumbers = ActivityItem::whereHas('program', function($q) use ($programming) {
            return $q->where('year', $programming->year);
        })->whereNotNull('int_code')->orderByRaw('LENGTH(int_code) ASC')->orderBy('int_code', 'ASC')
        ->distinct()->pluck('int_code');

        return view('programmings/programmingItems/index', compact('programming', 'tracerNumbers'));
    }

    public function create(Request $request)
    {  
        $year = Programming::find($request->programming_id)->year;
        $program_id = ActivityProgram::where('year', $year)->first()->id;
        $activityItems = ActivityItem::where('activity_id', $program_id)->orderByRaw('-int_code DESC')->get();
        $activityItemsSelect = $request->activity_search_id ? ActivityItem::where('id',(int)$request->activity_search_id)->first() : null;
        $programmingDays = ProgrammingDay::where('programming_id',$request->programming_id)->first();

        // $professionalHours = ProfessionalHour::with('professional')
        //                                      ->join('pro_professionals', 'pro_professional_hours.professional_id', '=', 'pro_professionals.id')
        //                                      ->where('programming_id', $request->programming_id)
        //                                      ->orderBy('pro_professionals.alias')->get();

        $professionalHours = ProfessionalHour::select(
                'pro_professional_hours.id'
                ,'pro_professional_hours.professional_id'
                ,'pro_professional_hours.programming_id'
                ,'pro_professional_hours.value'
                ,'T1.alias')
        ->leftjoin('pro_professionals AS T1', 'pro_professional_hours.professional_id', '=', 'T1.id')
        ->Where('programming_id',$request->programming_id)
        ->orderBy('T1.alias','ASC')
        ->get();

        return view('programmings/programmingItems/create', compact('activityItemsSelect', 'activityItems', 'programmingDays', 'professionalHours'));
    }

    public function show(Request $request, ProgrammingItem $programmingitem)
    {
        $programmingDays      = ProgrammingDay::where('programming_id',$programmingitem->programming_id)->first();

        $professionalHoursSel = ProfessionalHour::select(
                'pro_professional_hours.id'
                ,'pro_professional_hours.professional_id'
                ,'pro_professional_hours.programming_id'
                ,'pro_professional_hours.value'
                ,'T1.alias')
        ->leftjoin('pro_professionals AS T1', 'pro_professional_hours.professional_id', '=', 'T1.id')
        ->Where('pro_professional_hours.id',$programmingitem->professional)
        ->orderBy('T1.alias','ASC')
        ->first();
        
        // $professionalHours = ProfessionalHour::join('pro_professionals', 'pro_professional_hours.professional_id', '=', 'pro_professionals.id')
        //                                      ->where('programming_id', $programmingitem->programming_id)
        //                                      ->orderBy('pro_professionals.alias')->get();

        $professionalHours = ProfessionalHour::select(
                'pro_professional_hours.id'
                ,'pro_professional_hours.professional_id'
                ,'pro_professional_hours.programming_id'
                ,'pro_professional_hours.value'
                ,'T1.alias')
        ->leftjoin('pro_professionals AS T1', 'pro_professional_hours.professional_id', '=', 'T1.id')
        ->Where('programming_id',$programmingitem->programming_id)
        ->orderBy('T1.alias','ASC')
        ->get();

        return view('programmings/programmingItems/show', compact('programmingDays', 'professionalHoursSel', 'professionalHours'))->withProgrammingItem($programmingitem);

     }

    public function store(Request $request)
    {
        //dd($request->All());
        $programmingItems = new ProgrammingItem($request->All());
        //$programming->year = date('Y', strtotime($request->date));
        //$programming->description = $request->description;
        $programmingItems->user_id = Auth()->user()->id;
        $programmingItems->programming_id = $request->programming_id;
       
        $programmingItems->save();

        session()->flash('info', 'Se ha creado una nueva actividad de Programación Operativa');

        return redirect()->back();
        //return redirect()->route('programmingitems', ['programming_id' => 1]);
    }

    public function destroy($id)
    {
        // ELIMINA TODOS LAS OBSERVACIONES ANTES 
        $reviewItem = ReviewItem::where('programming_item_id',$id);
        $reviewItem->delete();

        $programmingItem = ProgrammingItem::where('id',$id)->first();
        $programmingItem->delete();

        session()->flash('success', 'El registro ha sido eliminado de este listado');
        return redirect('/programmingitems?programming_id='.$programmingItem->programming_id);
    }

    public function update(Request $request, ProgrammingItem $programmingitem)
    {
        $programmingitem->update($request->all());
        session()->flash('success', 'El registro se ha editado correctamente');
        return redirect()->back();
    }

    public function clone($id)
    {
        $programmingItemOriginal = ProgrammingItem::where('id',$id)->first();
        $programmingItemsClone = $programmingItemOriginal->replicate();
        $programmingItemsClone->user_id = Auth()->user()->id;
        $programmingItemsClone->save();
        session()->flash('success', 'El registro se ha duplicado correctamente');
        return redirect()->back();
    }

}
