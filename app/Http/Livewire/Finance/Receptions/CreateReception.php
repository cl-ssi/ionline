<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\Finance\PurchaseOrder;

class CreateReception extends Component
{
    public $purchaseOrderCode = '1272565-444-AG23';
    public $purchaseOrder;

    /**
    * Mount
    */
    public function mount()
    {
        $this->purchaseOrder = PurchaseOrder::whereCode($this->purchaseOrderCode)->first();
    }

    /**
    * Get Purchase Order
    */
    public function getPurchaseOrder()
    {
        $this->purchaseOrder = PurchaseOrder::whereCode($this->purchaseOrderCode)->first();
        //1272565-444-AG23
        app('debugbar')->log($this->purchaseOrder);
    }

    public function render()
    {
        return view('livewire.finance.receptions.create-reception');
    }
}
