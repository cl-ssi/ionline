<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class ManualDtes extends Component
{

    public $tipoDocumento = 'boleta_honorarios';
    public $folio;
    public $emisor;
    public $razonSocial;
    public $montoTotal;
    public $folioOC;
    public $showSuccessMessage = false;

    public function saveDte()
    {
        // Validar los campos antes de guardarlos
        $this->validate([
            'tipoDocumento' => 'required',
            'folio' => 'required',
            'emisor' => 'required',
            'razonSocial' => 'required',
            'montoTotal' => 'required',
            'folioOC' => 'required',
        ]);

        // Guardar los campos en el modelo Dte
        Dte::create([
            'tipo_documento' => $this->tipoDocumento,
            'folio' => $this->folio,
            'emisor' => $this->emisor,
            'razon_social' => $this->razonSocial,
            'monto_total' => $this->montoTotal,
            'folio_oc' => $this->folioOC,
        ]);

        // Reiniciar los campos del formulario después de guardar
        $this->resetFields();

         // Mostrar el mensaje de éxito
         $this->showSuccessMessage = true;

        
    }

    public function hideForm()
    {
        // Ocultar el formulario
        $this->emitUp('dteAdded');
    }

    public function resetFields()
    {
        $this->tipoDocumento = '';
        $this->folio = '';
        $this->emisor = '';
        $this->razonSocial = '';
        $this->montoTotal = '';
        $this->folioOC = '';
    }



    public function render()
    {
        return view('livewire.finance.manual-dtes');
    }
}
