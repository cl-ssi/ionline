<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class DteObservations extends Component
{
    public $dte;
    public $observation;
    public $successMessage = '';
    public $rows;
    public $cols;

    public function mount($dte, $rows = null, $cols = null)
    {
        $this->dte = $dte;
        $this->rows = $rows;
        $this->cols = $cols;
    }
    public function render()
    {
        return view('livewire.finance.dte-observations');
    }

    public function saveObservation()
    { 
        if($this->dte)
        {
            $observacion = now()->format('d-m-Y').' - '.auth()->user()->initials."\n".$this->observation."\n"; 
            $this->dte->observation .= $observacion; // Concatenar la nueva observación con las observaciones existentes
            $this->dte->save();
            $this->successMessage = 'Observacion Guardada exitosamente.';
            $this->observation = '';
        }
    }
    
}
