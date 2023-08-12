<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
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
}
