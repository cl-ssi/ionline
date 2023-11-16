<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\WebService\MercadoPublico;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Receptions\ReceptionItem;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;
use App\Models\Documents\Approval;

class CreateReception extends Component
{
    // '1057448-598-SE23' '1272565-444-AG23'  1272565-737-SE23;
    public $purchaseOrder = false;
    public $reception;
    public $receptionItems = [];
    public $types;
    public $signer_id;
    public $signer_ou_id;
    public $approvals = [];
    public $approvalUsers = [];
    public $authority = false;

    protected $listeners = ['userSelected', 'ouSelected'];

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
            // 'purchase_order' => '1057448-598-SE23',
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
            'creator_id' => auth()->id(),
            'creator_ou_id' => auth()->user()->organizational_unit_id,
        ]);
        // $status = MercadoPublico::getPurchaseOrderV2($this->reception->purchase_order);
        // $this->purchaseOrder = PurchaseOrder::whereCode($this->reception->purchase_order)->first();
        // $this->requestForm = $this->purchaseOrder?->requestForm;
    }

    /**
    * Get Purchase Order
    */
    public function getPurchaseOrder()
    {
        $status = MercadoPublico::getPurchaseOrderV2($this->reception->purchase_order);

        if($status === true) {
            $this->purchaseOrder = PurchaseOrder::whereCode($this->reception->purchase_order)->first();
            foreach($this->purchaseOrder->json->Listado[0]->Items->Listado as $key => $item){
                $this->receptionItems[$key] = ReceptionItem::make([]);
            }
        }
        else {
            $this->purchaseOrder = null;
        }

        //1272565-444-AG23
    }

    /**
    * Add Approval
    */
    public function addApproval($position, $user_id = null)
    {
        unset($this->approvals[$position]);

        $this->approvals[$position] = ([
            "module" => "Asistencia",
            "module_icon" => "fas fa-clock",
            "subject" => "Nuevo registro de asistencia",
            "document_route_name" => "rrhh.attendance.no-records.show",
            "document_route_params" => json_encode([
                "no_attendance_record_id" => "2863",
            ]),
            "position" => $position,
        ]);

        if($user_id OR $this->signer_id) {
            $this->approvals[$position]['sent_to_user_id'] = $user_id ?? $this->signer_id;
            $this->approvals[$position]['signerShortName'] = User::find($user_id ?? $this->signer_id)->shortName;
        }
        else if($this->signer_ou_id) {
            $this->approvals[$position]['sent_to_ou_id'] = $this->signer_ou_id;
            $this->approvals[$position]['signerShortName'] = $this->authority;
        }

    }

    /**
    * Remove Approval
    */
    public function removeApproval($position)
    {
        unset($this->approvals[$position]);
    }

    /**
    * Setea el signer_id
    */
    public function userSelected($user_id)
    {
        $this->signer_id = $user_id;
    }

    /**
    * Setea el signer_id
    */
    public function ouSelected($ou_id)
    {
        if($ou_id) {
            $ou = OrganizationalUnit::find($ou_id);
            if($ou->currentManager) {
                $this->authority = $ou->currentManager->user->shortName;
                $this->signer_ou_id = $ou_id;
            }
            else {
                $this->signer_ou_id = null;
                $this->authority = null;
            }
        }
    }

    /**
    * Save
    */
    public function save()
    {
        // $this->validate();
        // TODO: obtener el correlativo si es que no se especificó un correlativo (numero)
        app('debugbar')->log($this->reception->toArray());
        app('debugbar')->log($this->receptionItems);
        app('debugbar')->log($this->approvals);
        // $this->reception->save();
        // Guardar Items
        // Guardar approvals
    }

    public function render()
    {
        return view('livewire.finance.receptions.create-reception');
    }
}
