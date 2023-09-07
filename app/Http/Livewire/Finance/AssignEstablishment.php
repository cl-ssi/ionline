<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use App\Models\Establishment;

class AssignEstablishment extends Component
{

    public $dteId;
    public $selectedEstablishment;
    public $establishments;

    public function mount($dteId)
    {
        $this->dteId = $dteId;
        $this->selectedEstablishment = null; // Inicializar el valor seleccionado        
    }

    public function saveEstablishment()
    {
        $dte = Dte::find($this->dteId);
        if ($dte && $this->selectedEstablishment !== null) {
            $dte->establishment_id = $this->selectedEstablishment;
            $dte->save();
            session()->flash('success', 'El establecimiento fue asignado exitosamente al DTE');
        }
    }


    public function render()
    {
        return view('livewire.finance.assign-establishment');
    }
}
