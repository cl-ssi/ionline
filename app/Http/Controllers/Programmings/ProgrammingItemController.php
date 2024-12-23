<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programmings\Programming;
use App\Models\Programmings\ProgrammingItem;
use App\Models\Programmings\ProfessionalHour;
use App\Models\Programmings\ProgrammingDay;
use App\Models\Programmings\ActivityItem;
use App\Models\Programmings\ReviewItem;
use App\Models\Programmings\ActivityProgram;
use App\Models\Programmings\Professional;
use App\Models\Programmings\ProgrammingActivityItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class ProgrammingItemController extends Controller
{
    public function index(Request $request)
    {
        $listTracer = $request->tracer_number;
        $activityFilter = $request->activity;
        $cycleFilter = $request->cycle;
        $activityType = $request->activity_type;
        $categoryFilter = $request->category;
        $workAreaFilter = $request->work_area;
        $proFilter = $request->professional;

        $programming = Programming::whereId($request->programming_id)
            // busqueda de actividades sin filtro pero con tipo de actividad
            // ->when(!$listTracer && !$activityFilter && !$cycleFilter && $activityType == 'Directa', function ($q) use ($activityType){
            //     return $q->whereHas('items', $filter = function($q2) use ($activityType) {
            //         return $q2->when($activityType != null, function($q3) use ($activityType){
            //                     return $q3->where('activity_type', $activityType)->with('activityItem');
            //                 });
            //     })->with(['items' => $filter, 'items.reviewItems', 'items.professionalHour.professional', 'items.professionalHours.professional', 'establishment', 'pendingItems', 'items.user'])->get();
            // })
            // busqueda de actividades sin filtro ni tipo de actividad
            ->when(!$listTracer && !$activityFilter && !$cycleFilter, function ($q){
                return $q->with('items.activityItem', 'items.reviewItems', 'items.professionalHour.professional', 'items.professionalHours.professional', 'establishment', 'pendingItems', 'items.user', 'items.programming');
            })
            ->when($activityType == 'Directa' && ($listTracer || $activityFilter || $cycleFilter), function ($q) use ($listTracer, $activityFilter, $cycleFilter) {
                return $q->whereHas('items.activityItem', $filter = function($q2) use ($listTracer, $activityFilter, $cycleFilter) {
                    return $q2->when(!empty($listTracer), function($q3) use ($listTracer){
                                return $q3->Wherein('int_code', $listTracer);
                            })->when($activityFilter != null, function($q3) use ($activityFilter){
                                return $q3->whereRaw("UPPER(activity_name) LIKE '%". strtoupper($activityFilter)."%'");
                            })->when($cycleFilter != null, function($q3) use ($cycleFilter){
                                return $q3->where('vital_cycle', $cycleFilter);
                            });
                })->with(['items.activityItem' => $filter, 'items.reviewItems', 'items.professionalHour.professional', 'items.professionalHours.professional', 'establishment', 'pendingItems', 'items.user', 'items.programming'])->get();
             })
            ->when($activityType == 'Indirecta' && ($categoryFilter || $workAreaFilter || $proFilter), function($q) use ($categoryFilter, $workAreaFilter, $proFilter) {
                return $q->whereHas('items', $filter = function($q2) use ($categoryFilter, $workAreaFilter, $proFilter) {
                    return $q2->when($categoryFilter != null, function($q3) use ($categoryFilter){
                                return $q3->where('activity_category', $categoryFilter);
                            })->when($workAreaFilter != null, function($q3) use ($workAreaFilter){
                                return $q3->where('work_area', $workAreaFilter);
                            });
                            /* TODO: búsqueda por tipo de profesional */
                            // ->when($cycleFilter != null, function($q3) use ($cycleFilter){
                            //     return $q3->where('vital_cycle', $cycleFilter);
                            // });
                })->with(['items' => $filter, 'items.reviewItems', 'items.professionalHours.professional', 'establishment', 'pendingItems', 'items.user', 'items.programming'])->get();
            })
            ->first();

        if(!$programming){
            $programming = Programming::findorFail($request->programming_id);
            $programming->items = collect();
        }

        if($proFilter){
            $filteredItems = $programming->items->filter(fn($item) => $item->professionalHours->contains(fn($pro) => $pro->professional_id == $proFilter));
            $programming->items = $filteredItems;
        }

        // return $programming;

        // $tracerNumbers = ActivityItem::whereHas('program', function($q) use ($programming) {
        //     return $q->where('year', $programming->year);
        // })->whereNotNull('int_code')->orderByRaw('LENGTH(int_code) ASC')->orderBy('int_code', 'ASC')
        // ->distinct()->pluck('int_code');

        $q = ActivityItem::whereHas('program', function($q) use ($programming) {
            return $q->where('year', $programming->year);
        });

        $programActivities = $q->get(['id', 'activity_name', 'tracer', 'def_target_population', 'professional']);

        $scheduledActivities = collect();
        foreach($programming->items as $item)
            $scheduledActivities->add(new ActivityItem(['id' => $item->activity_id, 'activity_name' => $item->activity_name]));
        
        $diff = $programActivities->diff($scheduledActivities);
        $pendingActivities = $diff->all();

        $tracerNumbers = $q->whereNotNull('int_code')->orderByRaw('LENGTH(int_code) ASC')->orderBy('int_code', 'ASC')
        ->distinct()->pluck('int_code');

        $professionals = Professional::all();

        Session::put('items_url', request()->fullUrl());

        return view('programmings.programmingItems.index', compact('programming', 'tracerNumbers', 'pendingActivities', 'professionals'));
    }

    public function create(Request $request)
    {  
        $year = Programming::find($request->programming_id)->year;
        $program_id = ActivityProgram::where('year', $year)->first() ? ActivityProgram::where('year', $year)->first()->id : null;
        if(!$program_id){
            session()->flash('warning', 'No se ha iniciado la parametrización trazadoras para este año.');
            return redirect()->back();
        }
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

        return view('programmings.programmingItems.create', compact('activityItemsSelect', 'activityItems', 'programmingDays', 'professionalHours', 'year'));
    }

    public function show(Request $request, ProgrammingItem $programmingitem)
    {
        $programmingitem->load('professionalHours');
        $year = Programming::find($programmingitem->programming_id)->year;
        $activityItems = ActivityItem::whereHas('program', function($q) use ($year){
                            return $q->where('year', $year);
                        })->where('tracer', 'NO')->get();

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

        $reviewItem = ReviewItem::find($request->review_id);
        
        // se reasigna por defecto el profesional cuando se cumplan las condiciones (para que aparezca boton para agregar profesionales)
        if($reviewItem && $reviewItem->review == "Actividad pendiente por programar" && $programmingitem->professionalHours->count() == 0){
            $programmingitem->professionalHours()->attach($professionalHours->first()->id,
                                                        ['activity_performance' => 1, 
                                                        'designated_hours_weeks' => 1,
                                                        'hours_required_year' => 1, 
                                                        'hours_required_day' => 1, 
                                                        'direct_work_year' => 1, 
                                                        'direct_work_hour' => 1]);
        }

        return view('programmings.programmingItems.show', compact('programmingitem', 'programmingDays', 'professionalHoursSel', 'professionalHours', 'activityItems', 'reviewItem'))->withProgrammingItem($programmingitem);

     }

    public function store(Request $request)
    {
        // dd($request->All());
        $programmingItems = new ProgrammingItem($request->All());
        //$programming->year = date('Y', strtotime($request->date));
        //$programming->description = $request->description;
        $programmingItems->user_id = auth()->user()->id;
        $programmingItems->programming_id = $request->programming_id;
       
        $programmingItems->save();
        
        if($request->has('professionals')){
            foreach($request->get('professionals') as $professional){
                $programmingItems->professionalHours()->attach($professional['professional_hour_id'], 
                    ['activity_performance' => $professional['activity_performance'] ?? null, 
                     'designated_hours_weeks' => $professional['designated_hours_weeks'] ?? null,
                     'hours_required_year' => $professional['hours_required_year'], 
                     'hours_required_day' => $professional['hours_required_day'], 
                     'direct_work_year' => $professional['direct_work_year'], 
                     'direct_work_hour' => $professional['direct_work_hour']]);
            }
        }
        session()->flash('success', 'Se ha creado una nueva actividad de Programación Operativa');

        // return redirect()->back();
        return redirect()->route('programmingitems.show', $programmingItems);
    }

    public function destroy($id)
    {
        // ELIMINA TODOS LAS OBSERVACIONES ANTES 
        $reviewItem = ReviewItem::where('programming_item_id',$id);
        $reviewItem->delete();

        $programmingItem = ProgrammingItem::where('id',$id)->first();
        $programmingItem->delete();

        // $programmingItem->professionalHours()->detach();

        session()->flash('success', 'El registro ha sido eliminado de este listado');
        return redirect()->back();
    }
    
    public function destroyProfessionalHour(ProgrammingItem $programmingitem, $id)
    {
        $programmingitem->professionalHours()->wherePivot('id', $id)->detach();
        session()->flash('success', 'El item ha sido eliminado de este listado');
        return redirect()->back();
    }

    public function update(Request $request, ProgrammingItem $programmingitem)
    {
        // return $request;
        $programmingitem->load('professionalHours', 'programming');
        $programmingitem->fill($request->all());
        $programmingitem->prevalence_rate = $request->has('prevalence_rate') ? $request->prevalence_rate : null;
        $programmingitem->user_id = auth()->user()->id;
        $programmingitem->save();

        $programmingitem->professionalHours()->detach();

        if($request->has('professionals')){
            foreach($request->get('professionals') as $professional){
                $programmingitem->professionalHours()->attach($professional['professional_hour_id'], 
                    ['activity_performance' => $professional['activity_performance'] ?? null, 
                     'designated_hours_weeks' => $professional['designated_hours_weeks'] ?? null,
                     'hours_required_year' => $professional['hours_required_year'], 
                     'hours_required_day' => $professional['hours_required_day'], 
                     'direct_work_year' => $professional['direct_work_year'], 
                     'direct_work_hour' => $professional['direct_work_hour']]);
            }
        }

        if($request->has('review_id')){
            $reviewItem = ReviewItem::findOrFail($request->review_id);
            $reviewItem->rectified = "SI";
            $reviewItem->rect_comments = $request->rect_comments;
            $reviewItem->updated_by = auth()->user()->id;
            if($programmingitem->programming->year >= 2024) $reviewItem->answer = null;
            $reviewItem->save();

            session()->flash('success', 'Se ha rectificado correctamente la observación. <script>window.close()</script>');
            return redirect()->back();
        }

        session()->flash('success', 'El registro se ha editado correctamente');
        return redirect()->back();
    }

    public function clone($id)
    {
        $programmingItemOriginal = ProgrammingItem::find($id);
        $programmingItemsClone = $programmingItemOriginal->replicate();
        $programmingItemsClone->user_id = auth()->user()->id;
        $programmingItemsClone->push();

        $programmingItemOriginal->load('professionalHours');

        foreach($programmingItemOriginal->getRelations() as $relation => $items){
            if($relation == 'professionalHours'){
                foreach($items as $item){
                    unset($item->pivot->id);
                    $item->pivot->programming_item_id = $programmingItemsClone->id;
                    $extra_attributes = Arr::except($item->pivot->getAttributes(), $item->pivot->getForeignKey());
                    $programmingItemsClone->{$relation}()->attach($item, $extra_attributes);
                }
            }
        }
        session()->flash('success', 'El registro se ha duplicado correctamente');
        return redirect()->back();
    }

}
