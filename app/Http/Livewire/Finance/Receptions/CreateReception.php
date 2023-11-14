<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;

class CreateReception extends Component
{
    public $purchaseOrderCode = '1272565-444-AG23';
    public $purchaseOrder;
    public $reception;

    protected $rules = [
        'reception.number' => 'nullable',
        'reception.date' => 'nullable',
        'reception.doc_type' => 'nullable',
        'reception.doc_number' => 'nullable',
        'reception.doc_date' => 'nullable',
        'reception.header' => 'nullable',
        'reception.observation' => 'nullable',
    ];

    /**
    * Mount
    */
    public function mount()
    {
        $this->purchaseOrder = PurchaseOrder::whereCode($this->purchaseOrderCode)->first();
        $this->requestForm = $this->purchaseOrder->requestForm;
        $this->reception = new Reception();
    }

    /**
    * Get Purchase Order
    */
    public function getPurchaseOrder()
    {
        $this->purchaseOrder = PurchaseOrder::whereCode($this->purchaseOrderCode)->first();
        //1272565-444-AG23
    }

    public function render()
    {
        return view('livewire.finance.receptions.create-reception');
    }
}
