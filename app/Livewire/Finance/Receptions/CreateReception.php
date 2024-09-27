<?php

namespace App\Livewire\Finance\Receptions;

use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\WebService\MercadoPublico;
use App\Models\Parameters\Parameter;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Receptions\ReceptionItem;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;
use App\Models\Finance\Dte;
use App\Models\Documents\Correlative;
use App\Models\Documents\Approval;
use App\Models\Warehouse\Control;


class CreateReception extends Component
{
    use WithFileUploads;

    //   1272565-444-AG23 1057448-598-SE23 1272565-737-SE23;
    // public $purchaseOrderCode = '1057448-7-CM24';
    public $purchaseOrderCode;
    public $purchaseOrder = false;
    public $reception;
    public $receptionItems = [];
    public $maxItemQuantity = [];
    public $otherItems = [];
    public $types;
    public $signer_id;
    public $signer_ou_id;
    public $approvals = [];
    public $authority = false;
    public $selectedDteId;
    public $file_signed;
    public $support_file;
    public $control = null;

    public $receptionItemsWithCantidad; //para validación
    // public $message;

    /**
     * TODO:
     */
    public function rules()
    {
        /* Pasar a mayúsuculas la OC y hacerle un trim */
        $this->reception['purchase_order'] = trim(strtoupper($this->reception['purchase_order']));

        $reception = [
            'selectedDteId'             => 'required',
            'reception.number'          => 'nullable',
            'reception.date'            => 'required|date_format:Y-m-d',
            'reception.reception_type_id' => 'required',
            'reception.purchase_order'  => 'nullable',
            'reception.header_notes'    => 'nullable',
            'reception.footer_notes'    => 'nullable',
            'reception.partial_reception' => 'required|boolean',
            'reception.dte_type'        => 'required',
            'reception.dte_number'      => 'nullable',
            'reception.dte_date'        => 'nullable|date_format:Y-m-d',
            'reception.neto'            => 'nullable',
            'reception.descuentos'      => 'nullable',
            'reception.cargos'          => 'nullable',
            'reception.subtotal'        => 'nullable',
            'reception.iva'             => 'nullable',
            'reception.total'           => 'nullable',
            'reception.establishment_id'=> 'nullable',
            'reception.creator_id'      => 'nullable',
            'reception.creator_ou_id'   => 'nullable',
            'receptionItemsWithCantidad'=> 'required|array|min:1',
            'file_signed'               => 'nullable|mimes:pdf|max:10240',
            'approvals'                 => 'required|array|min:1',
        ];


        if( !empty($this->maxItemQuantity) ) {
            foreach($this->receptionItems as $key => $item) {
                $reception['receptionItems.'.$key.'.Cantidad'] = 'nullable|numeric|min:0|max:'.$this->maxItemQuantity[$key];
            }
        }

        // app('debugbar')->log($reception);
        return $reception;
    }

    protected $messages = [
        // 'reception.number' => 'nullable',
        // 'reception.date.require' => 'Es obligatoria',
        // 'reception.reception_type_id' => 'nullable',
        // 'reception.purchase_order' => 'nullable',
        // 'reception.header_notes' => 'nullable',
        // 'reception.footer_notes' => 'nullable',
        'reception.partial_reception.required' => 'Debe marcar si la recepción de la OC es parcial o completa',
        // 'reception.order_completed' => 'nullable',
        // 'reception.cenabast' => 'nullable',
        // 'reception.dte_type' => 'nullable',
        // 'reception.dte_number' => 'nullable',
        // 'reception.dte_date' => 'nullable|date_format:Y-m-d',
        // 'reception.total' => 'nullable',
        // 'reception.establishment_id' => 'nullable',
        // 'reception.creator_id' => 'nullable',
        // 'reception.creator_ou_id' => 'nullable',
        'receptionItems.*.Cantidad' => 'La cantidad está fuera de rango',
        'receptionItemsWithCantidad.required' => 'Debe ingresar la cantidad de al menos un item',
        'approvals.required' => 'Debe ingresar al menos un firmante',
    ];

    /**
    * Mount
    */
    public function mount($reception_id = null, $control_id = 0)
    {
        if($control_id <> 0 and $reception_id == null)
        {
            
            $control = Control::find($control_id);
            $this->control = $control;
            if( !$control->po_code ) {
                abort(403, 'La recepción en bodega no tiene número de Orden de Compra registrado, no se pude crear el acta de recepción sin OC.');
            }
            $receptionData = [
                'date' => $control->date,
                'purchase_order' => $control->po_code,
                'po_code' => $control->po_code,
                'dte_number' => $control->document_number,
            ];

            $this->purchaseOrderCode =  $control->po_code;
            //$this->purchaseOrder     = $control->purchaseOrder;
            $this->purchaseOrder    =  PurchaseOrder::where('code',$control->po_code)->first();
            $this->createArrayItemsFromOC();


            $this->reception = [
                'purchase_order'    => $this->purchaseOrderCode,
                'establishment_id'  => auth()->user()->organizationalUnit->establishment_id,
                'creator_id'        => auth()->id(),
                'creator_ou_id'     => auth()->user()->organizational_unit_id,
            ];

            //dd($this->purchaseOrder->json->Listado[0]->Items);

            
            /* Setear la cantidad por item e id que tiene la seteada el item */
            // $receptionItems =  $reception->items->toArray();
            // foreach($receptionItems as $item) {
            //     $this->receptionItems[$item['item_position']]['Cantidad'] = $item['Cantidad'];
            //     $this->receptionItems[$item['item_position']]['id']       = $item['id'];
            // }
        }


        if($reception_id and $control_id == 0) {
            $reception               = Reception::find($reception_id);
            $this->reception         = $reception->toArray();
            //dd($reception->toArray());
            $this->purchaseOrderCode = $reception->purchase_order;
            $this->purchaseOrder     = $reception->purchaseOrder;
            $this->selectedDteId     = $reception->dte_id ?? $reception->guia_id ?? null;

            /** Crear array por de los Items de la OC */
            $this->createArrayItemsFromOC();

            /* Setear la cantidad por item e id que tiene la seteada el item */
            $receptionItems =  $reception->items->toArray();
            foreach($receptionItems as $item) {
                $this->receptionItems[$item['item_position']]['Cantidad'] = $item['Cantidad'];
                $this->receptionItems[$item['item_position']]['id']       = $item['id'];
            }
            
            $this->getOtherReceptions($reception_id);

            foreach($reception->approvals as $approval) {
                $this->approvals[$approval->position] = $approval->toArray();
                if($approval->sent_to_ou_id) {
                    // dd($approval);
                    $this->approvals[$approval->position]['signerShortName'] = $approval->sentToOu->currentManager?->user->shortName;
                }
                else {
                    $this->approvals[$approval->position]['signerShortName'] = $approval->sentToUser->shortName;
                }
            }
            // dd($reception->approvals);
        }


        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();

        /** Esto es sólo para forzar que esté parametrizado el doc_type_id, antes de utilizar el módulo que se hace sólo una vez. */
        if( is_null(Parameter::get('Recepciones','doc_type_id')) ) {
            dd('Falta parametrizar el módulo "Recepciones" Parametro "doc_type_id" con el id del tipo de documento acta de recepción');
        }

        /* Esto precarga la OC*/
        if( array_key_exists('oc', $_GET) ) {
            $this->purchaseOrderCode = $_GET['oc'];
            $this->getPurchaseOrder();
        }

        /* Esto precarga el DTE, debe ir después de la precarga de OC, si no no funciona */
        if( array_key_exists('dte_id', $_GET) ) {
            $this->selectedDteId = $_GET['dte_id'];
            $this->getSelectedDte();
        }

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
            $this->reception        = [];
            $this->receptionItems   = [];
            $this->approvals        = [];
            $this->otherItems       = [];

            $this->reception = [
                'purchase_order'    => $this->purchaseOrderCode,
                'establishment_id'  => auth()->user()->organizationalUnit->establishment_id,
                'creator_id'        => auth()->id(),
                'creator_ou_id'     => auth()->user()->organizational_unit_id,
            ];

            $this->purchaseOrder = PurchaseOrder::whereCode($this->purchaseOrderCode)
                ->with('dtes')
                ->first();

            /** Crear array por de los Items de la OC */
            $this->createArrayItemsFromOC();

            $this->getOtherReceptions();

            /**
             * Esto no me convence mucho, hace que aparezcan los cargos y los decuentos luego de cargar la OC 
             * Estas dos líneas están dos veces, abajo en el calcular items también.
             */
            // TODO: Solo implementé el caso de los cargos totales, aún no he podido ver un caso con cargos en cada item. OC Ej: 1272565-905-AG23
            $this->reception['descuentos']       = $this->purchaseOrder->json->Listado[0]->Descuentos ?? 0;
            $this->reception['cargos']           = $this->purchaseOrder->json->Listado[0]->Cargos ?? 0;

            /**
             * Esto obtiene el tipo de formulario, si es un bien o un servicio
             * luego lo busca en el array de tipos de documentos y 
             * asigna el reception_type_id para que aparezca seleccionado
             */
            if($this->purchaseOrder->requestForm) {
                $this->reception['reception_type_id'] = array_search(
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
    * Calcular totales por item 
    */
    public function calculateItemTotal($key)
    {
        if(!$this->receptionItems[$key]['Cantidad']) {
            $this->receptionItems[$key]['Cantidad'] = 0;
        }
        $this->receptionItems[$key]['Total'] = $this->receptionItems[$key]['Cantidad'] * $this->receptionItems[$key]['PrecioNeto'];
        $this->calculateTotals();
    }

    /**
    * Calcular SubTotales y Totales generales
    */
    public function calculateTotals()
    {
        /** El neto redondeado hacia abajo */
        $this->reception['neto']             = round(array_sum(array_column($this->receptionItems, 'Total')), 0, PHP_ROUND_HALF_DOWN);
        $this->reception['subtotal']         = $this->reception['neto'] + floatval($this->reception['cargos']) - $this->reception['descuentos'];

        switch ($this->reception['dte_type'] ?? 'factura_electronica') {
            case 'boleta_honorarios':
                /**
                 * En el caso de las boletas de honorarios, el % de retención corresponde al campo "PorcentajeIva" en la OC.
                 * Para calcular el neto, primero calculando el valor de la retención redondeado
                 * Luego se resta al total de la boleta para obtener el neto.
                 * 
                 * Neto      = 1.292.997 (Este se calcula segundo: 1.499.000 - 206.113 = 1.292.997)
                 * Retención =   206.113 (Este se calcula primero y se redondea  1.499.000 * 13.75% = round(206.112,5) )
                 * Total     = 1.499.000 (A partir del total y del porcentaje de retención se calculan los dos de arriba)
                 * 
                 * Diferencia de la retención: EJ: 100% - 13.75% = 86.25% diferencia
                 **/

                $diferencia_de_impuesto   = (100 - $this->purchaseOrder->json->Listado[0]->PorcentajeIva) / 100;
                $this->reception['total'] = $this->reception['neto'] / $diferencia_de_impuesto;
                /** El impuesto siempre redondeado hacia arriba */
                $this->reception['iva']   = ceil($this->reception['total'] - $this->reception['neto']);
                $this->reception['total'] = $this->reception['iva'] + floor($this->reception['neto']);

                // $this->reception['total'] = $this->purchaseOrder->json->Listado[0]->Total;
                // $this->reception['iva'] = round($this->reception['total'] * $this->purchaseOrder->json->Listado[0]->PorcentajeIva / 100);
                // $this->reception['neto'] = $this->reception['subtotal'] = $this->reception['total'] - $this->reception['iva'];
                break;
            case 'factura_exenta':
            case 'factura_electronica':
            case 'guias_despacho':
            default:
                /** 
                 * Si el total de Impuestos en la OC es 0, es una OC exenta (caso de Pasajes de Avión)
                 * Las OC de pasajes de avión son hechas automáticamente por MP y no tienen impuestos. 
                 * 
                 * Tebi:
                 * Se modifica debido a solicitud y VC con Juan Toro y con Kurt, ahora podrán digitar el IVA.
                 * 
                 * Esto es para cuadrarlo con finanzas y no haya problema en pasar a pago el caso de Turavion
                 **/
                if( $this->purchaseOrder->json->Listado[0]->Impuestos == 0 ) {
                    if($this->purchaseOrder->requestForm && $this->purchaseOrder->requestForm->type_form != 'pasajes aéreos')
                        {
                            $this->reception['iva'] = 0;
                        }
                        if(isset($this->reception['iva']))
                        {
                            $this->reception['total'] = $this->reception['subtotal'] + $this->reception['iva'];
                        }
                        else
                        {
                            $this->reception['total'] = $this->reception['subtotal'];
                        }
                        
                }
                /** Aquí cae todas las demás DTEs */
                else {
                    $this->reception['iva']   = $this->purchaseOrder->json->Listado[0]->PorcentajeIva / 100 * $this->reception['subtotal'];  
                    $this->reception['total'] = $this->reception['iva'] + $this->reception['subtotal'];
                }
                break;
        }
    }

    /** Metodo mágico que captura el campo reception.cargos y se ejecuta si hay algún cambio */
    public function updatedReceptionCargos() {
        $this->calculateTotals();
    }

    /**
    * Get Other Receptions
    */
    public function getOtherReceptions($reception_id = null)
    {
        $otherReceptionItems = ReceptionItem::whereRelation('reception','purchase_order',$this->purchaseOrderCode)
            ->when( !is_null($reception_id), function ($query) use ($reception_id) {
                $query->whereNotIn('reception_id', [$reception_id]);
            })
            ->get()
            ->toArray();

        foreach($otherReceptionItems as $otherItems) {
            $this->otherItems[$otherItems['item_position']][]       = $otherItems;
            $this->maxItemQuantity[$otherItems['item_position']]    -= $otherItems['Cantidad'];
        }
    }


    /**
    * Create an Array of items from OC itmes
    */
    public function createArrayItemsFromOC()
    {
        foreach( $this->purchaseOrder->json->Listado[0]->Items->Listado as $key => $item ){
            $this->receptionItems[$key] = [
                'item_position'             => $key,
                'CodigoCategoria'           => $item->CodigoCategoria,
                'Producto'                  => $item->Producto,
                'Cantidad'                  => null,
                'Unidad'                    => $item->Unidad,
                'EspecificacionComprador'   => $item->EspecificacionComprador,
                'EspecificacionProveedor'   => $item->EspecificacionProveedor,
                'PrecioNeto'                => $item->PrecioNeto,
                'TotalDescuentos'           => $item->TotalDescuentos,
                'TotalCargos'               => $item->TotalCargos,
                'Total'                     => null,
            ];
            $this->maxItemQuantity[$key] = $item->Cantidad;
        }
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
            "module"        => "Recepcion",
            "module_icon"   => "fas fa-list",
            "subject"       => "Acta de recepción conforme",
            "document_route_name" => "finance.receptions.show",
            "position"      => $position,
            // "start_y"       => 0,
        ]);

        if($user_id OR $this->signer_id) {
            $this->approvals[$position]['sent_to_user_id'] = $user_id ?? $this->signer_id;
            $this->approvals[$position]['signerShortName'] = User::find($user_id ?? $this->signer_id)->shortName;
        }
        else if($this->signer_ou_id) {
            $this->approvals[$position]['sent_to_ou_id']   = $this->signer_ou_id;
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

    #[On('setTemplate')]
    public function setTemplate($input, $template){
        $this->reception[$input] = $template;
    }

    /**
    * Setea el signer_id
    */
    #[On('userSelected')]
    public function userSelected(User $user)
    {
        $this->signer_id = $user->id;
    }

    /**
    * Setea el signer_id
    */
    #[On('ouSelected')]
    public function ouSelected($organizationalUnitId)
    {
        if($organizationalUnitId) {
            $ou = OrganizationalUnit::find($organizationalUnitId);
            if($ou->currentManager) {
                $this->authority = $ou->currentManager->user->shortName;
                $this->signer_ou_id = $organizationalUnitId;
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
        /* Filtrar todos los items que no tienen cantidad null, para validación */
        $this->receptionItemsWithCantidad = array_filter(array_column($this->receptionItems, 'Cantidad'));

        $this->validate();

        /* Ordenar los approvals por importancia, left > center > right */
        $priorityOrder = ['left', 'center', 'right'];
        foreach($priorityOrder as $element) {
            if(key_exists($element,$this->approvals)) {
                $approvalsOrderedByPriority[] = $this->approvals[$element];
            }
        }

        /* Si la ultima firma fue enviada a una persona */
        if( array_key_exists('sent_to_user_id', end($approvalsOrderedByPriority) ) ) {
            $this->reception['responsable_id'] = end($approvalsOrderedByPriority)['sent_to_user_id'];
            $this->reception['responsable_ou_id'] = User::find($this->reception['responsable_id'])->organizational_unit_id;
        }
        else {
            /* Si la ultima firma fue enviada a una OU */
            $this->reception['responsable_ou_id'] = end($approvalsOrderedByPriority)['sent_to_ou_id'];
        }

        // app('debugbar')->log($this->reception);
        // app('debugbar')->log($this->receptionItems);
        // app('debugbar')->log($this->approvals);

        /* Crea la reception */
        $reception = Reception::updateOrCreate(
            ['id' => $this->reception['id'] ?? null],
            $this->reception
        );
        if ($this->control){
            $this->control->reception_id = $reception->id;
            $this->control->save();
            $this->control = null;
        }


        /* Guardar Items */
        foreach($this->receptionItems as $item) {
            if($item['Cantidad'] > 0) {
                $reception->items()->updateOrCreate(
                    ['id' => $item['id'] ?? null],
                    $item
                );
            }
        }

        /**
         * Si tiene un archivo signed_file para actas ya firmadas,
         * entonces no se crearn las aprobaciones porque el archivo aduntado
         * viene con las firmas, archivos legacy de retrocompatibilidad con 
         * el modulo de cenabast antiguo.
         */
        if($this->file_signed) {
            $storage_path = 'ionline/finances/receptions/signed_files';
            $filename = $reception->id.'.pdf';

            $this->file_signed->storeAs($storage_path, $filename, 'gcs');

            $reception->files()->create([
                'storage_path' => $storage_path.'/'.$filename,
                'stored' => true,
                'type' => 'signed_file',
                'stored_by_id' => auth()->id(),
            ]);
        }
        else {
            /** Crear los Approvals */
            $ctApprovals = count($approvalsOrderedByPriority);
            foreach($approvalsOrderedByPriority as $key => $approval) {
                /* Setear el reception_id que se obtiene despues de hacer el Reception::create();*/
                $approval["document_route_params"] = json_encode([
                    "reception_id" => $reception->id
                ]);

                /* Setear el filename */
                $approval["filename"] = 'ionline/finances/receptions/'.$reception->id.'.pdf';

                /* Si hay mas de un approval y no es el primero */
                if( count($approvalsOrderedByPriority) >= 1 AND $key != 0 ) {
                    /* Setea el previous_approval_id y active en false */
                    $approval["previous_approval_id"] = $reception->approvals()->latest('id')->value('id');
                    $approval["active"] = false;
                }

                /* Si es el último, entonces es el de firma electrónica */
                if (0 === --$ctApprovals) {
                    $approval["digital_signature"] = true;
                    $approval["callback_controller_method"] = 'App\Http\Controllers\Finance\Receptions\ReceptionController@approvalCallback';
                }

                //$reception->approvals()->create($approval);

                $reception->approvals()->updateOrCreate(
                    ['position' => $approval['position']],
                    $approval
                );
            }
        }




        /* Documento de respaldo: Support File */
        if($this->support_file) {
            $storage_path = 'ionline/finances/receptions/support_documents';
            $filename = $reception->id.'.pdf';

            $this->support_file->storeAs($storage_path, $filename, 'gcs');

            $reception->files()->create([
                'storage_path' => $storage_path.'/'.$filename,
                'stored' => true,
                'type' => 'support_file',
                'stored_by_id' => auth()->id(),
            ]);
        }

        /* Si el documento asociado a la recepcion es una GD preguntar si esa guia de despacho tiene asociada una factura dte->invoices si tiene asociada una factura tomar el id de la factura, ponerlo en el reception en el dte_id*/

        session()->flash('success', 'Su acta fue creada.');
        return redirect()->route('finance.receptions.index');
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
        // app('debugbar')->log($this->reception);
        // app('debugbar')->log($this->receptionItems);
        // app('debugbar')->log($this->approvals);
        // app('debugbar')->log($this->otherItems);
        return view('livewire.finance.receptions.create-reception');
    }

    public function updatedSelectedDteId()
    {
        if ($this->selectedDteId !== '0') {
            $this->getSelectedDte();
        } else {
            $this->resetReceptionValues();
        }
    }
    
    public function getSelectedDte()
    {
        $selectedDte = $this->purchaseOrder->dtes->where('id', $this->selectedDteId)->first();
        
        if ($selectedDte) {
            /* Si es de tipo guía de despacho */
            if( $selectedDte->tipo_documento == "guias_despacho" ) {
                $this->reception['guia_id'] = $selectedDte->id;
                if($selectedDte->invoices && $selectedDte->invoices->first()) {
                    $this->reception['dte_id']  = $selectedDte->invoices->first()->id;
                }
            }
            else {
                $this->reception['dte_id']  = $selectedDte->id;
            }
            $this->reception['dte_type']    = $selectedDte->tipo_documento;
            $this->reception['dte_number']  = $selectedDte->folio;
            $this->reception['dte_date']    = $selectedDte->emision?->format('Y-m-d');
        } 
    }
    
    public function resetReceptionValues()
    {
        $this->reception['guia_id']     = null;
        $this->reception['dte_id']      = null;
        $this->reception['dte_type']    = null;
        $this->reception['dte_number']  = null;
        $this->reception['dte_date']    = null;
    }

}
