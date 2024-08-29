<?php

namespace App\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\WebService\MercadoPublico;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;

class CreateRejection extends Component
{
    public $purchaseOrderCode;
    public $purchaseOrder;
    public $reception;
    public $selectedDteId;
    public $types;

    protected $rules = [
        'selectedDteId' => 'required',
        'reception.date' => 'required|date_format:Y-m-d',
        'reception.reception_type_id' => 'required',
        'reception.purchase_order' => 'required',
        'reception.rejected_notes' => 'required',
        'reception.dte_type' => 'required',
        'reception.dte_number' => 'nullable',
        'reception.dte_date' => 'nullable|date_format:Y-m-d',
    
        'reception.establishment_id' => 'nullable',
        'reception.creator_id' => 'nullable',
        'reception.creator_ou_id' => 'nullable',
        // 'approvals' => 'required|array|min:1',
    ];

    public function render()
    {
        return view('livewire.finance.receptions.create-rejection');
    }


    /**
    * Mount
    */
    public function mount()
    {
        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();
    }

    /**
    * Save
    */
    public function save()
    {
        $this->validate();
        $reception = Reception::make($this->reception);
        $reception->rejected = true;
        $reception->save();

        session()->flash('success', 'Su acta fue creada.');
        return redirect()->route('finance.receptions.index');
    }

    /**
    * Get Purchase Order
    */
    public function getPurchaseOrder()
    {
        $status = MercadoPublico::getPurchaseOrderV2($this->purchaseOrderCode);

        if($status === true) {
            /**
             * Limpiar las variables
             */
            $this->reception = [
                'purchase_order' => $this->purchaseOrderCode,
                'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
                'creator_id' => auth()->id(),
                'creator_ou_id' => auth()->user()->organizational_unit_id,
            ];

            $this->purchaseOrder = PurchaseOrder::whereCode($this->purchaseOrderCode)->with('dtes')->first();
            
            /**
             * Esto obtiene el tipo de formulario, si es un bien o un servicio
             * luego lo busca en el array de tipos de documentos y 
             * asigna el reception_type_id para que aparezca seleccionado
             */
            if($this->purchaseOrder->requestForm) {
                $this->reception['reception_type_id'] = array_search(
                    $this->purchaseOrder->requestForm->subTypeName, 
                    $this->types
                );
            }
        }
        else {
            $this->purchaseOrder = null;
        }
    }

    public function updatedSelectedDteId()
    {
        if ($this->selectedDteId !== '0') {
            $this->getSelectedDte();
        } else {
            $this->resetReceptionValues();
        }
    }
    
    public function getSelectedDte()
    {
        $selectedDte = $this->purchaseOrder->dtes->where('id', $this->selectedDteId)->first();
        
        if ($selectedDte) {
            /* Si es de tipo guía de despacho */
            if( $selectedDte->tipo_documento == "guias_despacho" ) {
                $this->reception['guia_id'] = $selectedDte->id;
            }
            else {
                $this->reception['dte_id']  = $selectedDte->id;
            }
            $this->reception['dte_type']    = $selectedDte->tipo_documento;
            $this->reception['dte_number']  = $selectedDte->folio;
            $this->reception['dte_date']    = $selectedDte->emision?->format('Y-m-d');
        } 
    }

    public function resetReceptionValues()
    {
        $this->reception['guia_id']     = null;
        $this->reception['dte_id']      = null;
        $this->reception['dte_type']    = null;
        $this->reception['dte_number']  = null;
        $this->reception['dte_date']    = null;
    }
}
