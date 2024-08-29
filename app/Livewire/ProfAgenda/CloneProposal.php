<?php

namespace App\Livewire\ProfAgenda;

use Livewire\Component;

use App\Models\ProfAgenda\Proposal;
use App\Models\ProfAgenda\ProposalDetail;

class CloneProposal extends Component
{
    public Proposal $proposal;
    public $proposals;
    public $selectedProposal;
    
    public $showSelect = false;

    public function openModal()
    {
        $this->showSelect = true;
    }

    public function hideSelect()
    {
        $this->showSelect = false;
    }

    public function save()
    {
        if($this->selectedProposal){
            $selectedProposal = Proposal::find($this->selectedProposal);
            if($selectedProposal->details->count() == 0){
                foreach($this->proposal->details as $detail){
                    $newdetail = new ProposalDetail();
                    $newdetail->proposal_id = $selectedProposal->id;
                    $newdetail->activity_type_id = $detail->activity_type_id;
                    $newdetail->day = $detail->day;
                    $newdetail->start_hour = $detail->start_hour;
                    $newdetail->end_hour = $detail->end_hour;
                    $newdetail->duration = $detail->duration;
                    $newdetail->save(); 
                }

                session()->flash('confirmation_message', 'Se ha clonado la propuesta.');
            }else{
                session()->flash('danger_message', 'No es posible clonar la propuesta, puesto que la propuesta objetivo ya tiene ingresado un horario.');
            }
        }
    }

    public function mount(){
        $this->proposals = Proposal::doesntHave('details')->get();
    }

    public function render()
    {
        return view('livewire.prof-agenda.clone-proposal');
    }
}
