<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class AssignCenabast extends Component
{
    public $dteId;
    public $isCenabast;

    public function mount($dteId)
    {
        $this->dteId = $dteId;
        $this->isCenabast = Dte::find($dteId)->cenabast;
    }

    public function toggleCenabast()
    {
        $dte = Dte::find($this->dteId);

        if ($dte) {
            $dte->cenabast = $this->isCenabast ? 1 : 0;
            $dte->save();
            // Guardar el mensaje en la sesión
            session()->flash('message', 'El estado de Cenabast fue actualizado correctamente.');
        }
    }


    public function render()
    {
        return view('livewire.finance.assign-cenabast');
    }
}
