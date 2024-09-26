<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;
use Livewire\WithFileUploads;


class ManualDtes extends Component
{

    //public $tipoDocumento = 'boleta_honorarios';
    use WithFileUploads;
    public $tipoDocumento;
    public $folio;
    public $emisor;
    public $razonSocial;
    public $montoTotal;
    public $folioOC;
    public $emision;
    public $barCode;
    public $showSuccessMessage = false;
    public $storage_path = '/ionline/finances/dte/carga_manual';
    public $comprobante_liquidacion_fondo;
    public $archivoManual;
    public $pagoManual;
    
    /*
    NOTA 
    No hay representacion para el tipo de documento boleta_electronica 
    nosotros de manera interna estamos informando como codigo 77 para llevar cierto control.
    Se verifica en la documentacion del SII que no existe este código para algo que ellos manejen, por eso se tomó ese número*/

    public $tipoDocumentoMap = [
        'factura_exenta' => 34,
        'factura_electronica' => 33,
        'guias_despacho' => 52,
        'nota_credito' => 61,
        'boleta_electronica' => 77,
        'boleta_honorarios' => 69,

        //hacer un distinct o algo para buscar los demas o buscar en la documentacion del SII
    ];


    public function saveDte()
    {

        $tipo = $this->tipoDocumentoMap[$this->tipoDocumento];

        // Validar los campos antes de guardarlos
        $this->validate([
            'tipoDocumento' => 'required',
            'folio' => 'required|numeric',
            'emisor' => 'required',
            'razonSocial' => 'required',
            'montoTotal' => 'required|numeric',
            //'folioOC' => 'required',
            'emision' => 'required',
            'archivoManual' => 'file|mimes:pdf|max:4096|nullable',
            'pagoManual' => 'nullable|boolean',
            
        ]);

        // Generar el último campo de la URI
        $runFilter  = preg_replace('/[^0-9K]/', '', $this->emisor);
        $user_id  = substr($runFilter, 0, -1);

        $boleta_numero = str_pad($this->folio, 5, '0', STR_PAD_LEFT);
        $codigo_barra = $this->barCode;
        $uri_last_field = $user_id . $boleta_numero . $codigo_barra;


        if($this->emisor)
        {
            $value = preg_replace('/[^0-9K]/', '', strtoupper(trim($this->emisor)));
            $dv = substr($value, -1);
            $id = substr($value, 0, -1);
            $this->emisor = number_format($id, 0, '', '.').'-'.$dv;
        }

        // Guardar los campos en el modelo Dte
        $dte_manual = Dte::create([
            'tipo_documento' => $this->tipoDocumento,
            'folio' => $this->folio,
            'emisor' => $this->emisor,
            'razon_social_emisor' => $this->razonSocial,
            'monto_total' => $this->montoTotal,
            'folio_oc' => $this->folioOC,
            'emision' => $this->emision,
            'tipo' => $tipo,
            'paid_manual' => $this->pagoManual ?? false,
            'establishment_id' => auth()->user()->establishment_id
        ]);


        $filePath = null;
        if ($this->archivoManual) {
            $file = $this->archivoManual;
            $filename = $file->getClientOriginalName();
            $filePath = $file->storeAs($this->storage_path, $filename, ['disk' => 'gcs']);
        }

        if ($filePath) {
            if($this->pagoManual) {
                $dte_manual->archivo_carga_manual = $filePath;
            } else {
                $dte_manual->comprobante_liquidacion_fondo = $filePath;
            }
            $dte_manual->save();
        }

        if ($this->tipoDocumento == 'boleta_honorarios') {
            // Solo guardo el URI si es boleta de honorario
            $dte_manual->uri = 'https://loa.sii.cl/cgi_IMT/TMBCOT_ConsultaBoletaPdf.cgi?origen=TERCEROS&txt_codigobarras=' . $uri_last_field;
            $dte_manual->save();
        }

        // Reiniciar los campos del formulario después de guardar
        $this->resetFields();

        // Mostrar el mensaje de éxito
        $this->showSuccessMessage = true;
    }

    public function hideForm()
    {
        // Ocultar el formulario
        $this->dispatch('dteAdded');
    }

    public function getDistinctTipoDocumento()
    {
        return Dte::distinct('tipo_documento')->pluck('tipo_documento');
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
        $this->archivoManual = '';
    }

    public function verBoleta()
    {
        // Validar el campo de código de barra antes de redirigir a la URL
        $this->validate([
            'tipoDocumento' => 'required',
            'folio' => 'required|numeric',
            'emisor' => 'required',
            'razonSocial' => 'required',
            'montoTotal' => 'required|numeric',
            'emision' => 'required',
            //'folioOC' => 'required',
            //'barCode' => 'required|size:7',
        ]);

        // Generar la URL de la boleta utilizando el código de barra
        $runFilter = preg_replace('/[^0-9K]/', '', $this->emisor);
        $user_id = substr($runFilter, 0, -1);
        $boleta_numero = str_pad($this->folio, 5, '0', STR_PAD_LEFT);
        $codigo_barra = $this->barCode;
        $uri_last_field = $user_id . $boleta_numero . $codigo_barra;
        $boleta_url = 'https://loa.sii.cl/cgi_IMT/TMBCOT_ConsultaBoletaPdf.cgi?origen=TERCEROS&txt_codigobarras=' . $uri_last_field;

        // Redirigir a la URL de la boleta
        return redirect()->to($boleta_url);
    }




    public function render()
    {
        return view('livewire.finance.manual-dtes');
    }
}
