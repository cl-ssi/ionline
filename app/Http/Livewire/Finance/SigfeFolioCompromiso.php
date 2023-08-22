<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class SigfeFolioCompromiso extends Component
{
    
    public $nuevoFolioCompromiso = null; 
    public $dteId;
    public $successMessage = '';

    // Recibe el ID del DTE cuando se carga el componente
    public function mount($dteId)
    {
        $this->dteId = $dteId;
        $dte = Dte::find($this->dteId);
        if ($dte) {
            $this->nuevoFolioCompromiso = $dte->folio_compromiso_sigfe;
        }
    }

    public function render()
    {
        return view('livewire.finance.sigfe-folio-compromiso');
    }

    public function guardarFolioCompromiso()
    {
        // Aquí obtienes el Dte correspondiente y actualizas el campo
        $dte = Dte::find($this->dteId);
        if ($dte) {
            $dte->folio_compromiso_sigfe = $this->nuevoFolioCompromiso;
            $dte->save();
            $this->successMessage = 'Folio compromiso sigfe guardado exitosamente.';
            
        }
    }
}
