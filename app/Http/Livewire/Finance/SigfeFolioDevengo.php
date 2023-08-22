<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class SigfeFolioDevengo extends Component
{
    public $nuevoFolioDevengo = null;
    public $dteId;
    public $successMessage = '';

    public function mount($dteId)
    {
        $this->dteId = $dteId;
        $dte = Dte::find($this->dteId);
        if ($dte) {
            $this->nuevoFolioDevengo = $dte->folio_devengo_sigfe;
        }
    }

    public function render()
    {
        return view('livewire.finance.sigfe-folio-devengo');
    }

    public function guardarFolioDevengo()
    {
        // Aquí obtienes el Dte correspondiente y actualizas el campo
        $dte = Dte::find($this->dteId);
        if ($dte) {
            $dte->folio_devengo_sigfe = $this->nuevoFolioDevengo;
            $dte->save();
            $this->successMessage = 'Folio devengo sigfe guardado exitosamente.';
        }
    }
}
