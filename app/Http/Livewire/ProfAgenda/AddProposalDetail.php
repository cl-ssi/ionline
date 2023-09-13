<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

use App\Models\ProfAgenda\Proposal;
use App\Models\ProfAgenda\ProposalDetail;
use App\Models\ProfAgenda\ActivityType;

class AddProposalDetail extends Component
{
    public $proposal;
    public $activity_types;

    public $day;
    public $start_hour;
    public $end_hour;
    public $duration;
    public $activity_type_id;

    public function mount(){
        $this->activity_types = ActivityType::all();
    }

    public function save(){
        // valida si existe el datalle en otras propuestas del mismo trabajador
        $proposals = Proposal::where('user_id',$this->proposal->user_id)
                            ->where('id','<>',$this->proposal->id)
                            ->get();

        if($this->start_hour >= $this->end_hour){
            session()->flash('message', 'No es posible agregar, horario de inicio es mayor o igual al horario de término.');
            return 0;
        }

        // dd($proposals);
        foreach($proposals as $proposal){
            // primero verifica que el rango de fechas de la propuesta coincida con otras propuestas que se revisan.
            if($proposal->start_date <= $this->proposal->start_date && $this->proposal->start_date <= $proposal->end_date ||
               $proposal->start_date <= $this->proposal->end_date && $this->proposal->end_date <= $proposal->end_date){
                // se hace revisión por día de cada detalle ingresado
                foreach($proposal->details->where('day',$this->day) as $detail){
                    if($detail->start_hour == $this->start_hour && $detail->end_hour == $this->end_hour){
                        session()->flash('message', 'No es posible agregar este horario puesto que se presenta coincidencias con bloques de otras propuestas.');
                        return 0;
                    }
                    if($detail->start_hour < $this->start_hour && $detail->end_hour > $this->start_hour){
                        session()->flash('message', 'No es posible agregar este horario puesto que se presenta coincidencias con bloques de otras propuestas.');
                        return 0;
                    }
                    if($detail->start_hour < $this->end_hour && $detail->end_hour > $this->end_hour){
                        session()->flash('message', 'No es posible agregar este horario puesto que se presenta coincidencias con bloques de otras propuestas.');
                        return 0;
                    }
                    if($detail->start_hour > $this->start_hour && $detail->start_hour < $this->end_hour){
                        session()->flash('message', 'No es posible agregar este horario puesto que se presenta coincidencias con bloques de otras propuestas.');
                        return 0;
                    }
                }
            }   
        }

        // ingresa nuevo detalle
        $proposalDetail = new ProposalDetail();
        $proposalDetail->proposal_id = $this->proposal->id;
        $proposalDetail->day = $this->day;
        $proposalDetail->start_hour = $this->start_hour;
        $proposalDetail->end_hour = $this->end_hour;
        $proposalDetail->duration = $this->duration;
        $proposalDetail->activity_type_id = $this->activity_type_id;
        
        $proposalDetail->save();

        $this->proposal->refresh();
        // $this->emit('update_calendar');

        // dd(url()->current());
        // return redirect()->to(url()->current());
    }

    public function delete($detail){
        $ProposalDetail = ProposalDetail::find($detail['id']);
        $ProposalDetail->delete();

        $this->proposal->refresh();
        $this->emit('update_calendar', $this->proposal);
    }

    public function render()
    {
        return view('livewire.prof-agenda.add-proposal-detail');
    }
}
