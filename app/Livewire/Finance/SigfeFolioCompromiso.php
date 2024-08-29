<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class SigfeFolioCompromiso extends Component
{
    public $nuevoFolioCompromiso = null;
    public $dte;
    public $successMessage = '';
    public $editing = false;
    public $onlyRead = false;

    // Recibe el ID del DTE cuando se carga el componente
    public function mount($dte)
    {
        $this->dte = $dte;
        $this->nuevoFolioCompromiso = $dte->folio_compromiso_sigfe;
    }

    public function render()
    {
        return view('livewire.finance.sigfe-folio-compromiso');
    }

    public function guardarFolioCompromiso()
    {
        if ($this->dte) {
            $this->dte->folio_compromiso_sigfe = $this->nuevoFolioCompromiso;
            $this->dte->save();
            $this->successMessage = 'Folio compromiso sigfe guardado exitosamente.';
        }
        $this->toggleEditing();
    }

    public function toggleEditing()
    {
        $this->editing = !$this->editing;
    }
}
