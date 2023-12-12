<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Dte;
use App\Models\Finance\Receptions\Reception;

class CreateReceptionNoOc extends Component
{
    use WithFileUploads;

    public $digitalInvoiceFile;
    public $additionalField;
    public $types;
    public $storage_path = '/ionline/finances/dte/carga_manual';
    public $reception;
    public $montoTotal;
    public $folio;
    public $razonSocial;
    public $emisor;
    

    protected $rules = [
        'digitalInvoiceFile' => 'required|file|max:2048', // ajusta el tamaño máximo según tus necesidades
        'reception.dte_type' => 'required',
        'reception.emisor' => 'required',
        'reception.razonSocial' => 'required',
        'reception.folio' => 'required|numeric|min:1',
        'reception.montoTotal' => 'required|numeric|min:1000',
    ];

    public $tipoDocumentoMap = [
        'factura_exenta' => 34,
        'factura_electronica' => 33,
        'guias_despacho' => 52,
        'nota_credito' => 61,
        'boleta_electronica' => 77,
        'boleta_honorarios' => 69,

        //hacer un distinct o algo para buscar los demas o buscar en la documentacion del SII
    ];



    public function render()
    {
        return view('livewire.finance.receptions.create-reception-no-oc');
    }


    public function mount()
    {
        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();
    }

    public function save()
    {
        $tipo = $this->tipoDocumentoMap[$this->reception['dte_type']];
        $dte_manual = Dte::create([
            'tipo_documento' => $this->reception['dte_type'],
            'folio' => $this->folio,
            'emisor' => $this->emisor,
            'razon_social_emisor' => $this->razonSocial,
            'monto_total' => $this->montoTotal,
            'tipo' => $tipo,
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
        ]);
        
        Reception::create([
            'reception_type_id' => $this->reception['reception_type_id'],
            'date' => $this->reception['date'],
            'creator_id' => auth()->user()->id,
            'creator_ou_id' => auth()->user()->organizational_unit_id,
            'responsable_id' => auth()->user()->id,
            'responsable_ou_id' => auth()->user()->organizational_unit_id,
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
            'dte_id' => $dte_manual->id,
            'dte_type' => $this->reception['dte_type'],
            'header_notes' => $this->reception['header_notes'],
            'total' => $this->montoTotal,
        ]);

        session()->flash('success', 'Su acta sin OC fue creada exitosamente.');
        return redirect()->route('finance.receptions.create_no_oc');

    }


}
