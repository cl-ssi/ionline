<?php

namespace App\Services;

use App\Models\RequestForms\ImmediatePurchase;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\PurchasingProcessDetail;

class PurchaseOrderService
{
    /**
     * @param  string  $purchase_order_code
     * @return  \App\Models\RequestForms\RequestForm|null
     */
    public function getRequestForm($purchase_order_code)
    {
        $request_form = null;
        $immediatePurchase = ImmediatePurchase::wherePoId($purchase_order_code)->first();

        if($immediatePurchase)
        {
            $purchasingDetail = PurchasingProcessDetail::whereImmediatePurchaseId($immediatePurchase->id)->first();
            if($purchasingDetail)
            {
                $purchasingProcess = PurchasingProcess::find($purchasingDetail->purchasing_process_id);
                if($purchasingProcess)
                {
                    $request_form = $purchasingProcess->requestForm;
                }
            }
        }

        return $request_form;
    }
}
