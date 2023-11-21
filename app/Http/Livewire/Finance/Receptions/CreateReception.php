<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\WebService\MercadoPublico;
use App\Models\Parameters\Parameter;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Receptions\ReceptionItem;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;
use App\Models\Documents\Correlative;
use App\Models\Documents\Approval;

class CreateReception extends Component
{
    //   1272565-444-AG23 1057448-598-SE23 1272565-737-SE23;
    public $purchaseOrderCode = '1272565-444-AG23';
    public $purchaseOrder = false;
    public $reception;
    public $receptionItems = [];
    public $maxItemQuantity = [];
    public $otherItems = [];
    public $types;
    public $signer_id;
    public $signer_ou_id;
    public $approvals = [];
    public $approvalUsers = [];
    public $authority = false;

    protected $listeners = ['userSelected', 'ouSelected', 'setTemplate'];

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
        'reception.doc_type' => 'nullable',
        'reception.doc_number' => 'nullable',
        'reception.doc_date' => 'nullable|date_format:Y-m-d',
        'reception.neto' => 'nullable',
        'reception.descuentos' => 'nullable',
        'reception.cargos' => 'nullable',
        'reception.subtotal' => 'nullable',
        'reception.iva' => 'nullable',
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
        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();

        /** Esto es sólo para forzar que esté parametrizado el doc_type_id, antes de utilizar el módulo que se hace sólo una vez. */
        if( is_null(Parameter::get('Recepciones','doc_type_id')) ) {
            dd('Falta parametrizar el módulo "Recepciones" Parametro "doc_type_id" con el id del tipo de documento acta de recepción');
        }
    }

    public function setTemplate($input, $template){
        $this->$input = $template;
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
            $this->receptionItems = [];
            $this->approvals = [];
            $this->otherItems = [];

            $this->reception = new Reception([
                'purchase_order' => $this->purchaseOrderCode,
                'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
                'creator_id' => auth()->id(),
                'creator_ou_id' => auth()->user()->organizational_unit_id,
            ]);

            $this->purchaseOrder = PurchaseOrder::whereCode($this->reception->purchase_order)->first();
            foreach($this->purchaseOrder->json->Listado[0]->Items->Listado as $key => $item){
                $this->receptionItems[$key] = ReceptionItem::make([
                    'item_position' => $key,
                    'CodigoCategoria' => $item->CodigoCategoria,
                    'Producto' => $item->Producto,
                    'Cantidad' => null,
                    'Unidad' => $item->Unidad,
                    'EspecificacionComprador' => $item->EspecificacionComprador,
                    'EspecificacionProveedor' => $item->EspecificacionProveedor,
                    'PrecioNeto' => $item->PrecioNeto,
                    'TotalDescuentos' => $item->TotalDescuentos,
                    'TotalCargos' => $item->TotalCargos,
                    'Total' => null,
                ]);
                $this->maxItemQuantity[$key] = $item->Cantidad;
            }
            $otherReceptionItems = ReceptionItem::whereRelation('reception','purchase_order',$this->reception->purchase_order)->get();
            foreach($otherReceptionItems as $otherItems) {
                $this->otherItems[$otherItems->item_position][$otherItems->reception->number] = $otherItems['Cantidad'];
                $this->maxItemQuantity[$otherItems->item_position] -= $otherItems['Cantidad'];
            }


            /**
             * Esto obtiene el tipo de formulario, si es un bien o un servicio
             * luego lo busca en el array de tipos de documentos y 
             * asigna el reception_type_id para que aparezca seleccionado
             */
            if($this->purchaseOrder->requestForm) {
                $this->reception->reception_type_id = array_search(
                    $this->purchaseOrder->requestForm->subTypeName, 
                    $this->types
                );
            }
        }
        else {
            $this->purchaseOrder = null;
        }
    }

    /**
    * calculateItemTotal
    */
    public function calculateItemTotal($key)
    {
        if(!$this->receptionItems[$key]['Cantidad']) {
            $this->receptionItems[$key]['Cantidad'] = 0;
        }
        $this->receptionItems[$key]['Total'] = $this->receptionItems[$key]['Cantidad'] * $this->receptionItems[$key]['PrecioNeto'];

        $this->reception->neto = array_sum(array_column($this->receptionItems, 'Total'));
        // TODO: Falta agregar cargos y descuentos
        $this->reception->subtotal = $this->reception->neto; 
        $this->reception->iva = $this->purchaseOrder->json->Listado[0]->PorcentajeIva / 100 * $this->reception->subtotal;
        $this->reception->total = $this->reception->iva + $this->reception->subtotal;
    }

    /**
    * set purchase order Completed
    */
    public function setPurchaseOrderCompleted()
    {
        $this->purchaseOrder->completed = true;
        $this->purchaseOrder->save();
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
        // Validar que tenga al menos un approval
        if(count($this->approvals) >= 1)
        {
            if(key_exists('right',$this->approvals)) {
                $responsable = 'right';
            }
            else if(key_exists('center',$this->approvals)) {
                $responsable = 'center';
            }
            else {
                $responsable = 'left';
            }
        }
        else {
            dd('Debe tener al menos un firmante');
        }
        
        $this->reception->responsable_id = $this->approvals[$responsable]['sent_to_user_id'] ?? null;
        $this->reception->responsable_ou_id = $this->approvals[$responsable]['sent_to_ou_id'] ?? null;
    
        // Validar que tenga por le menos un receptionItems con cantidad > 0

        /* Obtener el correlativo si es que no se especificó un correlativo (numero) */
        if( !$this->reception->number ) {
            $this->reception->number = Correlative::getCorrelativeFromType(Parameter::get('Recepciones','doc_type_id'));
        }

        app('debugbar')->log($this->reception->toArray());
        app('debugbar')->log($this->receptionItems);
        app('debugbar')->log($this->approvals);


        /* Guardar reception */
        $this->reception->save();

        /* Guardar Items */
        foreach($this->receptionItems as $item) {
            if($item['Cantidad'] > 0) {
                $this->reception->items()->create($item);
            }
        }

        /* Guardar approvals */
        foreach($this->approvals as $approval) {
            $this->reception->approvals()->create($approval);
        }


    }

    /**
     * Toggle PurchaseOrder Cenabast
     */
    public function togglePoCenabast()
    {
        $this->purchaseOrder->cenabast = !$this->purchaseOrder->cenabast;
        $this->purchaseOrder->save();
    }

    /**
     * Toggle Purchase Order Complete
     */
    public function togglePoCompleted()
    {
        $this->purchaseOrder->completed = !$this->purchaseOrder->completed;
        $this->purchaseOrder->save();
    }

    /**
    * preview
    */
    public function preview()
    {
        
    }

    public function render()
    {
        return view('livewire.finance.receptions.create-reception');
    }
}
