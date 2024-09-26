<?php

namespace App\Livewire\Finance;

use App\Models\Finance\Dte;

use Livewire\Component;

class SendInstitutional extends Component
{
    public $dte;

    public $dteId;

    public $checked;

    public $manual = false;

    public function mount()
    {
        $this->dteId = $this->dte->id;
        $this->checked = $this->dte->paid_manual;
    }

    public function updatedChecked()
    {
        $this->dte->update(['paid_manual' =>  $this->checked ? true : false]);
        return [];
    }

    public function render()
    {
        return view('livewire.finance.send-institutional', ['dteId' => $this->dteId]);
    }
}
