<?php

namespace App\Http\Controllers\ProfAgenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProfAgenda\Proposal;
use App\Models\ProfAgenda\OpenHour;
use App\Models\Parameters\Profession;
use App\User;

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
        $proposals = Proposal::all();
        return view('prof_agenda.proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professions = Profession::whereIn('id',[1,4,5,6])->get();
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
        $proposal = new Proposal($request->All());
        $proposal->status = "Creado";
        $proposal->save();

        session()->flash('info', 'La propuesta ha sido registrada.');
        return redirect()->route('prof_agenda.proposals.index');
        // return $this->edit($proposal);
    }

    /**
     * Show a created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        $professions = Profession::whereIn('id',[1,4,5,6])->get();
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
        $professions = Profession::whereIn('id',[1,4,5,6])->get();
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
        $user_id_param = $request->user_id;
        
        $start_date_param = null;
        $end_date_param = null;
        if($request->start_date){
            $start_date_param = Carbon::parse($request->start_date);
        }
        if($request->end_date){
            $end_date_param = Carbon::parse($request->end_date);
        }

        $proposals = Proposal::where('user_id',$user_id_param)
                            // ->when($start_date_param, function ($q) use ($start_date_param) {
                            //     return $q->where('start_date','<=',$start_date_param);
                            // })
                            // ->when($start_date_param, function ($q) use ($start_date_param) {
                            //     return $q->where('end_date','>=',$start_date_param);
                            // })
                            // ->when($end_date_param, function ($q) use ($end_date_param) {
                            //     return $q->where('end_date','>=',$end_date_param);
                            // })
                            // ->where('status','Creado')
                            ->get();

                            // dd($proposals);

        // valida no mas de 30 dias
        if($start_date_param && $end_date_param){
            $diff = $start_date_param->diffInDays($end_date_param);
            if($diff>30){
                session()->flash('warning', 'Se permite un máximo de 30 días para aperturar.');
                $request->flash();
                return redirect()->back();
            }
        }
        
        // dd($start_date_param, $end_date_param, $proposals);

        $block_dates = array();
        $count = 0;
        foreach($proposals as $proposal){
            // dd($proposal);
            foreach (CarbonPeriod::create($start_date_param, '1 day', $end_date_param) as $date) {
                // solo si está dentro del segmento de la propuesta
                if($date >= $proposal->start_date && $date <= $proposal->end_date){
                    foreach($proposal->details->where('day',$date->dayOfWeek) as $detail){
                        // dd($detail);
    
                        // crea bloques de horarios
                        $duration = $detail->duration . ' minutes';
                        
                        foreach (CarbonPeriod::create($detail->start_hour, $duration, $detail->end_hour)->excludeEndDate() as $key => $hour) {
                            // dd($hour);
    
                            $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['start_date'] = $date->format('Y-m-d') . " " . $hour->format('H:i');
                            $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['end_date'] = Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($detail->duration)->format('Y-m-d H:i');
                            $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['activity_name'] = $detail->activityType->name;
    
                            // verifica si existe el bloque, si no existe, lo crea.
                            $openHour = OpenHour::where('proposal_detail_id',$detail->id)
                                                ->where('start_date',$date->format('Y-m-d') . " " . $hour->format('H:i'))
                                                ->where('end_date',Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($detail->duration)->format('Y-m-d H:i'))
                                                ->get();
    
                            // dd($openHour);
                            if($openHour->count()==0){
                                // bloques nuevos
                                $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['color'] = '#85C1E9';
                                $newOpenHour = new OpenHour();
                                $newOpenHour->proposal_detail_id = $detail->id;
                                $newOpenHour->start_date = $date->format('Y-m-d') . " " . $hour->format('H:i');
                                $newOpenHour->end_date = Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($detail->duration)->format('Y-m-d H:i');
                                // dd($newOpenHour);
                                $newOpenHour->save();
                                
                                $count += 1;
    
                                $proposal->status = "Aperturado";
                                $proposal->save();
                            }else{
                                // bloques ya existentes
                                $block_dates[$date->format('Y-m-d') . " " . $hour->format('H:i')]['color'] = '#f5c6bf';
                            }
                        }
                    }
                }
            }
        }

        $users = User::whereHas('agendaProposals')->get();

        if($count>0){
            session()->flash('success', 'Se han creado ' . $count . ' bloques.');
        }
        if($count==0){session()->flash('warning', 'No se ha creado ningún bloque.');}

        $request->flash();
        return view('prof_agenda.open_calendar',compact('users','request','block_dates'));
    }
}
