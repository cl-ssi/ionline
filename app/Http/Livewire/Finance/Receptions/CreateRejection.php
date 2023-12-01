<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\WebService\MercadoPublico;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;

class CreateRejection extends Component
{
    public $purchaseOrderCode = '1272565-444-AG23';
    public $purchaseOrder;
    public $reception;

    public function render()
    {
        return view('livewire.finance.receptions.create-rejection');
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

            $this->reception = new Reception([
                'purchase_order' => $this->purchaseOrderCode,
                'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
                'creator_id' => auth()->id(),
                'creator_ou_id' => auth()->user()->organizational_unit_id,
            ]);

            $this->purchaseOrder = PurchaseOrder::whereCode($this->reception->purchase_order)->with('dtes')->first();

        }
        else {
            $this->purchaseOrder = null;
        }
    }
}
