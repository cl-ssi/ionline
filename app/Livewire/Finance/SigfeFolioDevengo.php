<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class SigfeFolioDevengo extends Component
{
    public $nuevoFolioDevengo = null;
    public $dte;
    public $successMessage = '';
    public $editing = false;
    public $onlyRead = false;

    // Recibe el ID del DTE cuando se carga el componente
    public function mount($dte)
    {
        $this->dte = $dte;
        $this->nuevoFolioDevengo = $dte->folio_devengo_sigfe;
    }

    public function render()
    {
        return view('livewire.finance.sigfe-folio-devengo');
    }

    public function guardarFolioDevengo()
    {
        if ($this->dte) {
            $this->dte->folio_devengo_sigfe = $this->nuevoFolioDevengo;
            $this->dte->save();
            $this->successMessage = 'Folio devengo sigfe guardado exitosamente.';
        }
        $this->toggleEditing();
    }

    public function toggleEditing()
    {
        $this->editing = !$this->editing;
    }
}
