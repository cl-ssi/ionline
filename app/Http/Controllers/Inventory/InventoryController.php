<?php

namespace App\Http\Controllers\Inventory;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Inv\InventoryMovement;
use App\Models\Inv\Inventory;
use App\Models\Documents\Approval;
use App\Http\Controllers\Controller;
use App\Exports\InventoriesExport;
use App\Models\Parameters\Place;
use App\Models\Establishment;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $approvalSender = $this->getApprovalLegacyAttribute($movement->senderUser ?? null, $movement);

        $approvalResponsible = $this->getApprovalLegacyAttribute($movement->inventory->responsible, $movement);

        $approvalUsing = $this->getApprovalLegacyAttribute($movement->inventory->using, $movement);

        return view('inventory.pdf.act-transfer', compact('movement', 'approvalSender', 'approvalResponsible'));
    }

    /**
     * Build the approval according to the approver
     *
     * @param  mixed  $approver
     * @return \App\Models\Documents\Approval|null
     */
    public function getApprovalLegacyAttribute($approver = null, InventoryMovement $movement = null)
    {
        if(! isset($approver))
        {
            return null;
        }

        $approval = new Approval();
        $approval->status = 1;
        $approval->approver_id = $approver->id;
        $approval->approver_at = $movement->reception_date ?? now();
        $approval->sent_to_ou_id = $approver->organizational_unit_id;
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


    public function export() 
    {
        return Excel::download(new InventoriesExport, 'inventarios.xlsx');
    }

    public function sheet() 
    {
        return view('inventory.sheet');
    }

    public function board(Establishment $establishment, Place $place)
    {
        $inventories = Inventory::where('place_id', $place->id)->get();

        $qrCodeSvg = QrCode::format('svg')->size(150)->errorCorrection('H')->generate(route('parameters.places.board', [
            'establishment' => $establishment->id,
            'place' => $place->id
        ]));


        $qrcode = base64_encode($qrCodeSvg);

        
        
        return PDF::loadView('inventory.board', [
            'place' => $place,
            'establishment' => $establishment,
            'inventories' => $inventories,
            'qrcode' => $qrcode,
        ])->setPaper('a4', 'landscape')->stream('planilla-mural-'.$place->name.'.pdf');
    }
    


}
