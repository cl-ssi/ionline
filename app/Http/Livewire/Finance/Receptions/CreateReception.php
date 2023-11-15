<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;
use App\Models\Documents\Approval;

class CreateReception extends Component
{
    public $purchaseOrderCode = '1272565-444-AG23';
    public $purchaseOrder;
    public $reception;
    public $types;
    public $signer_id;
    public $approvals = [];

    protected $listeners = ['userSelected'];

    /**
     * TODO:
     */

    protected $rules = [
        'reception.number' => 'nullable',
        'reception.date' => 'required|date_format:Y-m-d',
        'reception.reception_type_id' => 'required',
        'reception.purchase_order' => 'nullable',
        'reception.header_notes' => 'nullable',
        'reception.footer_notes' => 'nullable',
        'reception.partial_reception' => 'boolean',
        'reception.order_completed' => 'boolean',
        'reception.cenabast' => 'boolean',
        'reception.doc_type' => 'nullable',
        'reception.doc_number' => 'nullable',
        'reception.doc_date' => 'nullable|date_format:Y-m-d',
        'reception.total' => 'nullable',
        'reception.establishment_id' => 'nullable',
        'reception.creator_id' => 'nullable',
        'reception.creator_ou_id' => 'nullable',
    ];

    protected $messages = [
        // 'reception.number' => 'nullable',
        // 'reception.date.require' => 'Es obligatoria',
        // 'reception.reception_type_id' => 'nullable',
        // 'reception.purchase_order' => 'nullable',
        // 'reception.header_notes' => 'nullable',
        // 'reception.footer_notes' => 'nullable',
        // 'reception.partial_reception' => 'nullable',
        // 'reception.order_completed' => 'nullable',
        // 'reception.cenabast' => 'nullable',
        // 'reception.doc_type' => 'nullable',
        // 'reception.doc_number' => 'nullable',
        // 'reception.doc_date' => 'nullable|date_format:Y-m-d',
        // 'reception.total' => 'nullable',
        // 'reception.establishment_id' => 'nullable',
        // 'reception.creator_id' => 'nullable',
        // 'reception.creator_ou_id' => 'nullable',
    ];

    /**
    * Mount
    */
    public function mount()
    {
        $this->types = ReceptionType::pluck('name','id');
        $this->reception = new Reception([
            'purchase_order' => '1272565-444-AG23',
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
            'creator_id' => auth()->id(),
            'creator_ou_id' => auth()->user()->organizational_unit_id,
        ]);
        $this->purchaseOrder = PurchaseOrder::whereCode($this->reception->purchase_order)->first();
        $this->requestForm = $this->purchaseOrder->requestForm;
    }

    /**
    * Get Purchase Order
    */
    public function getPurchaseOrder()
    {
        $this->purchaseOrder = PurchaseOrder::whereCode($this->reception->purchase_order)->first();
        //1272565-444-AG23
    }

    /**
    * Add Approval
    */
    public function addApproval($position, $user_id = null)
    {

        $this->approvals[] = ([
            "module" => "Asistencia",
            "module_icon" => "fas fa-clock",
            "subject" => "Nuevo registro de asistencia",
            "document_route_name" => "rrhh.attendance.no-records.show",
            "document_route_params" => json_encode([
                "no_attendance_record_id" => "2863",
            ]),
            "sent_to_user_id" => $user_id ?? $this->signer_id,
            "position" => "center",
        ]);

        app('debugbar')->log($this->approvals);

    }

    /**
    * 
    */
    public function userSelected($user_id)
    {
        $this->signer_id = $user_id;
    }

    /**
    * Save
    */
    public function save()
    {
        // $this->validate();
        app('debugbar')->log($this->reception);
        // $this->reception->save();
        // Guardar Items
        // Guardar approvals
    }

    public function render()
    {
        return view('livewire.finance.receptions.create-reception');
    }
}
