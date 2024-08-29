<?php

namespace App\Livewire\Agreements;

use Livewire\Component;

use App\Models\Agreements\ProgramQuotaMinsal;
use App\Models\Agreements\Program;

class AddQuotasMinsal extends Component
{
    public $edit = false;
    public $program;
    public $description;
    public $percentage;
    public $amount;
    public $transfer_at;
    public $voucher_number;

    public function edit()
    {
        $this->edit = true;
    }

    public function cancel(){
        $this->edit = false;
    }

    public function save(){
        $programQuotaMinsal = new ProgramQuotaMinsal();
        $programQuotaMinsal->description = $this->description;
        $programQuotaMinsal->percentage = $this->percentage;
        $programQuotaMinsal->amount = $this->amount;
        $programQuotaMinsal->transfer_at = $this->transfer_at;
        $programQuotaMinsal->voucher_number = $this->voucher_number;
        $programQuotaMinsal->program_id = $this->program->id;
        $programQuotaMinsal->save();

        session()->flash('success', 'Se ha agregado correctamente la cuota minsal.');
    }

    public function delete(ProgramQuotaMinsal $quote){
        $quote->delete();
        session()->flash('success', 'Se ha eliminado correctamente la cuota minsal.');
    }
    
    public function render()
    {
        $this->program = Program::find($this->program->id);
        return view('livewire.agreements.add-quotas-minsal');
    }
}
