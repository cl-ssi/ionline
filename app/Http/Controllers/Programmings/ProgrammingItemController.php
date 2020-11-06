<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Programming;
use App\Programmings\ProgrammingItem;
use App\Programmings\ProfessionalHour;
use App\Programmings\MinisterialProgram;
use App\Programmings\ProgrammingDay;
use App\Programmings\ActivityItem;
use App\Programmings\ActionType;
use App\User;
use App\Establishment;
use App\Models\Commune;

class ProgrammingItemController extends Controller
{
    public function index(Request $request)
    {
        $year = '';
        //$programmingitems = ProgrammingItem::where('programming_id',$request->programming_id)->OrderBy('id')->get();

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
                                ,'T7.tracer AS tracer')
                        ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                        ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                        ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                        ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                        ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                        ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                        ->leftjoin('pro_activity_items AS T7', 'pro_programming_items.activity_id', '=', 't7.id')
                        ->Where('T0.year','LIKE','%'.$year.'%')
                        ->Where('pro_programming_items.cycle','!=','TALLER')
                        ->where('pro_programming_items.programming_id',$request->programming_id)
                        ->orderBy('pro_programming_items.cycle','ASC')
                        ->orderBy('pro_programming_items.action_type','ASC')
                        ->orderBy('pro_programming_items.activity_name','ASC')
                        ->get();
            
    $programmingitems_workshop = ProgrammingItem::select(
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
                           ,'pro_programming_items.activity_group'
                           ,'pro_programming_items.workshop_number'
                           ,'pro_programming_items.workshop_session_number'
                           ,'pro_programming_items.workshop_session_time'
                           
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
                           ,'T3.value AS professional_value')
                   ->leftjoin('pro_programmings AS T0', 'T0.id', '=', 'pro_programming_items.programming_id')
                   ->leftjoin('establishments AS T1', 'T0.establishment_id', '=', 'T1.id')
                   ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                   ->leftjoin('pro_professional_hours AS T3','T3.id', '=', 'pro_programming_items.professional')
                   ->leftjoin('pro_professionals AS T4', 'T3.professional_id', '=', 'T4.id')
                   ->leftjoin('users AS T5', 'T0.user_id', '=', 'T5.id')
                   ->Where('T0.year','LIKE','%'.$year.'%')
                   ->Where('pro_programming_items.workshop','=','SI')
                   ->where('pro_programming_items.programming_id',$request->programming_id)
                   ->orderBy('pro_programming_items.cycle','ASC')
                   ->orderBy('pro_programming_items.action_type','ASC')
                   ->orderBy('pro_programming_items.activity_name','ASC')
                   ->get();

        //dd($programmingitems);

        return view('programmings/programmingItems/index')->withProgrammingItems($programmingitems)->withProgrammingItemworkshops($programmingitems_workshop);

    }

    public function create(Request $request)
    {
        if($request->activity_search_id)
        {
           
            $activityItemsSelect = ActivityItem::where('id',(int)$request->activity_search_id)->first();

        }
        else{
            $activityItemsSelect = null;
        }
        $establishments = Establishment::where('type','CESFAM')->OrderBy('name')->get();
        $communes = Commune::All()->SortBy('name');
        //$professionalHours = ProfessionalHour::where('programming_id',$request->programming_id)->OrderBy('id')->get();
        $ministerialPrograms = MinisterialProgram::All()->SortBy('name');
        $actionTypes = ActionType::All()->SortBy('name');
        $activityItems = ActivityItem::All()->SortBy('name');
        $programmingDay = ProgrammingDay::where('programming_id',$request->programming_id)->first();
        


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


        return view('programmings/programmingItems/create')->withEstablishments($establishments)
                                                          ->withActivityItems($activityItems)
                                                          ->withProfessionalHours($professionalHours)
                                                          ->withMinisterialPrograms($ministerialPrograms)
                                                          ->withActionTypes($actionTypes)
                                                          ->withProgrammingDays($programmingDay)
                                                          ->with('activityItemsSelect', $activityItemsSelect);
    }

    public function show(Request $request, ProgrammingItem $programmingitem)
    {
        //dd($programmingitem);
        
        if($request->activity_search_id)
        {
           
            $activityItemsSelect = ActivityItem::where('id',(int)$request->activity_search_id)->first();
             //dd($activityItemsSelect);

        }
        else{
            $activityItemsSelect = null;
        }
        $establishments = Establishment::where('type','CESFAM')->OrderBy('name')->get();
        $communes = Commune::All()->SortBy('name');
        //$professionalHours = ProfessionalHour::where('programming_id',$request->programming_id)->OrderBy('id')->get();
        $ministerialPrograms = MinisterialProgram::All()->SortBy('name');
        $actionTypes = ActionType::All()->SortBy('name');
        $activityItems = ActivityItem::All()->SortBy('name');
        $programmingDay = ProgrammingDay::where('programming_id',$programmingitem->programming_id)->first();
        $programmingItem = ProgrammingItem::where('id',$request->id)->first();
        //dd($programmingitem);

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

        //dd($professionalHoursSel);



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


        return view('programmings/programmingItems/show')->withProgrammingItem($programmingitem)
                                                          ->withEstablishments($establishments)
                                                          ->withActivityItems($activityItems)
                                                          ->withProfessionalHours($professionalHours)
                                                          ->withMinisterialPrograms($ministerialPrograms)
                                                          ->withActionTypes($actionTypes)
                                                          ->withProgrammingDays($programmingDay)
                                                          ->with('activityItemsSelect', $activityItemsSelect)
                                                          ->with('professionalHoursSel', $professionalHoursSel);;

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
      $programmingItem = ProgrammingItem::where('id',$id)->first();
      $programmingItem->delete();

      session()->flash('success', 'El registro ha sido eliminado de este listado');
       return redirect()->back();
    }

    public function update(Request $request, ProgrammingItem $programmingitem)
    {
      //dd($request);
      $programmingitem->fill($request->all());
      $programmingitem->save();
      return redirect()->back();
    }

}
