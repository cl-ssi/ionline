<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Models\WebService\MercadoPublico;
use App\Models\Finance\PurchaseOrder;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{
    /**
    * Show
    */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $documentFile = \PDF::loadView('finance.purchase_order', compact('purchaseOrder'));
        return $documentFile->stream();
    }

    /**
    * Show
    */
    public function showByCode($po_code)
    {
        $status = MercadoPublico::getPurchaseOrderV2($po_code);
        if($status === true) {
            $purchaseOrder = PurchaseOrder::whereCode($po_code)->first();
            $documentFile = \PDF::loadView('finance.purchase_order', compact('purchaseOrder'));
            return $documentFile->stream();
        }
        else
        {
            echo $status;
        }
    }
}
