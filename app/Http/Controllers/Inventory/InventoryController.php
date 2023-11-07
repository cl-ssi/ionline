<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Documents\Approval;
use App\Models\Inv\InventoryMovement;

class InventoryController extends Controller
{
    /**
     * Create the inventory product transfer record
     *
     * @param  Movement  $movement
     * @return \Illuminate\Contracts\Support\Arrayable
     */
    public function actTransfer(InventoryMovement $movement)
    {
        $approvalSender = $this->getApprovalLegacyAttribute($movement->senderUser ?? null);

        $approvalResponsible = $this->getApprovalLegacyAttribute($movement->inventory->responsible);

        $approvalUsing = $this->getApprovalLegacyAttribute($movement->inventory->using);

        return view('inventory.pdf.act-transfer', compact('movement', 'approvalSender', 'approvalResponsible'));
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
        $approval->sent_to_ou_id = $approver->organizational_unit_id;
        return $approval;
    }
}
