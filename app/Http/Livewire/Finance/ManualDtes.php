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
    public $barCode;
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
            'barCode' => 'required|size:7',
        ]);

        // Generar el último campo de la URI
        $user_id = $this->emisor; // Ejemplo: Reemplaza esto con la lógica para obtener el ID de usuario
        $boleta_numero = str_pad($this->folio, 5, '0', STR_PAD_LEFT);
        $codigo_barra = $this->barCode;
        $uri_last_field = $user_id . $boleta_numero . $codigo_barra;

        // Guardar los campos en el modelo Dte
        Dte::create([
            'tipo_documento' => $this->tipoDocumento,
            'folio' => $this->folio,
            'emisor' => $this->emisor,
            'razon_social' => $this->razonSocial,
            'monto_total' => $this->montoTotal,
            'folio_oc' => $this->folioOC,
            'uri' => 'https://loa.sii.cl/cgi_IMT/TMBCOT_ConsultaBoletaPdf.cgi?origen=TERCEROS&txt_codigobarras=' . $uri_last_field,
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
        $this->barCode = '';
    }



    public function render()
    {
        return view('livewire.finance.manual-dtes');
    }
}
