<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\WebService\MercadoPublico;
use App\Models\Finance\Dte;

class GetPurchaseOrder extends Component
{
    public Dte $dte;
    public $message;

    /**
    * Get Purchase Order From Mercado Publico
    */
    public function getPurchaseOrder()
    {
        $status = MercadoPublico::getPurchaseOrderV2($this->dte->folio_oc);
        // app('debugbar')->log($status);
        if($status === true) {
            $this->message = null;
            $this->dte->refresh();
        }
        else {
            $this->message = $status;
        }
    }

    public function render()
    {
        return view('livewire.finance.get-purchase-order');
    }
}
