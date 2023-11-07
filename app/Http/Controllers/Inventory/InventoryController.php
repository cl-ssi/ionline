<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Documents\Approval;
use App\Models\Inv\Inventory;

class InventoryController extends Controller
{
    /**
     * Create the inventory product transfer record
     *
     * @param  Inventory  $inventory
     * @return \Illuminate\Contracts\Support\Arrayable
     */
    public function actTransfer(Inventory $inventory)
    {
        $approvalSender = $this->getApprovalLegacyAttribute($inventory->lastMovement->senderUser ?? null);

        $approvalResponsible = $this->getApprovalLegacyAttribute($inventory->responsible);

        $approvalUsing = $this->getApprovalLegacyAttribute($inventory->using);

        return view('inventory.pdf.act-transfer', compact('inventory', 'approvalSender', 'approvalResponsible'));
    }

    /**
     * Build the approval according to the approver
     *
     * @param  mixed  $approver
     * @return \App\Models\Documents\Approval|null
     */
    public function getApprovalLegacyAttribute($approver = null)
    {
        if(! isset($approver))
        {
            return null;
        }

        $approval = new Approval();
        $approval->status = 1;
        $approval->approver_id = $approver->id;
        $approval->approver_at = now();
        return $approval;
    }

    /**
     * Discharge document
     *
     * @param  Inventory  $inventory
     * @return void
     */
    public function dischargeDocument(Inventory $inventory)
    {
        if(isset($inventory->discharge_date) && isset($inventory->act_number))
        {
            return view('inventory.pdf.discharge-document', compact('inventory'));
        }

        return abort(404);
    }
}
