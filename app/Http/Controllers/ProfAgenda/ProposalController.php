<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProfAgenda\Proposal;
use App\Models\ProfAgenda\OpenHour;
use App\Models\Parameters\Profession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Parameters\Holiday;
use App\Models\Parameters\Parameter;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('Agenda UST: Administrador')){
            $proposals = Proposal::orderBy('id','DESC')->get();
        }
        if(auth()->user()->can('Agenda UST: Funcionario')){
            $proposals = Proposal::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        }
        
        return view('prof_agenda.proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        $professions = Profession::whereIn('id',$professions)->get();
        return view('prof_agenda.proposals.create',compact('professions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        
        $proposal = Proposal::where('user_id',$request->user_id)->where('end_date','>=',$request->start_date)->first();
        if($proposal){
            $proposal->end_date = Carbon::parse($request->start_date)->addDays(-1);
            $proposal->save();
        }

        $proposal = new Proposal($request->All());
        $proposal->status = "Creado";
        $proposal->save();

        if($proposal){
            session()->flash('info', 'La propuesta ha sido registrada. Se ha modificado la fecha de término de la propuesta anterior para evitar solapamiento de horarios.');
        }else{
            session()->flash('info', 'La propuesta ha sido registrada.');
        }
        
        return redirect()->route('prof_agenda.proposals.index');
    }

    /**
     * Show a created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        $professions = Profession::whereIn('id',$professions)->get();
        return view('prof_agenda.proposals.show', compact('proposal','professions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        $professions = explode(',',Parameter::where('parameter','profesiones_ust')->pluck('value')->toArray()[0]);
        $professions = Profession::whereIn('id',$professions)->get();
        return view('prof_agenda.proposals.edit', compact('proposal','professions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        $proposal->fill($request->all());
        $proposal->save();

        session()->flash('info', 'La propuesta ha sido actualizada.');
        return redirect()->route('prof_agenda.proposals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
      $proposal->delete();
      session()->flash('success', 'La propuesta ha sido eliminada');
      return redirect()->route('prof_agenda.proposals.index');
    }

    public function open_calendar(Request $request)
    {
        $start_date_param = $request->start_date;
        $end_date_param = $request->end_date;

        $proposals = Proposal::where('user_id',$request->user_id)->get();

        // valida no mas de 60 dias
        if($start_date_param && $end_date_param){
            
            $diff = (int) Carbon::parse($request->start_date)->diffInDays($end_date_param);
            if($diff>60){
                session()->flash('warning', 'Se permite un máximo de 60 días para aperturar.');
                return redirect()->back()->withInput();
            }
            
            if($start_date_param <= now()){
                session()->flash('warning', 'No se puede aperturar. La fecha inicial que ingresó es igual o anterior a la actual.');
                return redirect()->back()->withInput();
            }
            
        }

        $block_dates = array();
        $count = 0;
        
        if($proposals->count() > 0){
            foreach($proposals as $proposal){
                // dd($proposal);
                foreach (CarbonPeriod::create($start_date_param, '1 day', $end_date_param) as $date) {
                    // solo si está dentro del segmento de la propuesta
                    if($date >= $proposal->start_date && $date <= $proposal->end_date){
                        foreach($proposal->details->where('day',$date->dayOfWeek) as $detail){
                            // solo si es de un tipo reservable
                            if($detail->activityType && $detail->activityType->reservable){
                                // crea bloques de horarios
                                $duration = $detail->duration . ' minutes';
                                
                                $holiday = Holiday::where('date', $date)->first();
                                
                                // si no es feriado
                                if(!$holiday){
                                    foreach (CarbonPeriod::create($detail->start_hour, $duration, $detail->end_hour)->excludeEndDate() as $key => $hour) {
            
                                        $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['start_date'] = $date->format('Y-m-d') . " " . $hour->format('H:i');
                                        $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['end_date'] = Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($detail->duration)->format('Y-m-d H:i');
                                        $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['activity_name'] = $detail->activityType->name;
                
                                        // verifica si existe el bloque, si no existe, lo crea.
                                        $openHour = OpenHour::where('proposal_detail_id',$detail->id)
                                                            ->where('start_date',$date->format('Y-m-d') . " " . $hour->format('H:i'))
                                                            ->where('end_date',Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($detail->duration)->format('Y-m-d H:i'))
                                                            ->get();
                
        
                                        if($openHour->count()==0){
                                            // bloques nuevos
                                            $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['color'] = '#85C1E9'; //azul
                                            $newOpenHour = new OpenHour();
                                            $newOpenHour->proposal_detail_id = $detail->id;
                                            $newOpenHour->start_date = $date->format('Y-m-d') . " " . $hour->format('H:i');
                                            $newOpenHour->end_date = Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($detail->duration)->format('Y-m-d H:i');
                                            
                                            $newOpenHour->profesional_id = $proposal->user_id;
                                            $newOpenHour->profession_id = $proposal->profession_id; 
                                            $newOpenHour->activity_type_id = $detail->activity_type_id;
                                            $newOpenHour->save();
                                            
                                            $count += 1;
                
                                            $proposal->status = "Aperturado";
                                            $proposal->save();
                                        }else{
                                            // bloques ya existentes
                                            $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['color'] = '#f5c6bf'; //rojo
                                        }
                                    }
                                }else{
                                    // si es feriado
                                    $block_dates[$date->format('Y-m-d') . " 00:00"]['start_date'] = $date->format('Y-m-d') . " 00:00";
                                    $block_dates[$date->format('Y-m-d') . " 00:00"]['end_date'] = $date->format('Y-m-d') . " 23:59";
                                    $block_dates[$date->format('Y-m-d') . " 00:00"]['activity_name'] = "Feriado: " . $holiday->name;
                                    $block_dates[$date->format('Y-m-d') . " 00:00"]['color'] = '#E7EB89'; //amarillo
                                }
                                
                            }
                        }
                    }
                }
            }

            // validación para msg
            if($count > 0){
                session()->flash('success', 'Se han creado ' . $count . ' bloques.');
                return redirect()->back()->withInput();
            }
            if($count == 0){
                session()->flash('warning', 'No se ha creado ningún bloque.');
                return redirect()->back()->withInput();
            }
        }
        

        // se devuelve usuarios según rol asignado
        if(auth()->user()->can('Agenda UST: Administrador') || auth()->user()->can('Agenda UST: Secretaria')){
            $users = User::whereHas('agendaProposals', function($q){
                                        $q->whereIn('status',['Aperturado','Creado'])
                                            ->where('end_date','>=',now()->format('Y-m-d'));
                                    })->get();
                                }
        if(auth()->user()->can('Agenda UST: Funcionario')){
            $users = User::whereHas('agendaProposals', function($q){
                                $q->whereIn('status',['Aperturado','Creado'])
                                    ->where('end_date','>=',now()->format('Y-m-d'));
                            })->where('id',auth()->id())->get();
        }

        return view('prof_agenda.open_calendar',compact('users','request','block_dates'));
    }
}
