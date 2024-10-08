<?php

namespace App\Livewire\Finance\Receptions;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Dte;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\Receptions\ReceptionItem;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;

class CreateReceptionNoOc extends Component
{
    use WithFileUploads;

    public $digitalInvoiceFile;
    public $additionalField;
    public $types;
    public $storage_path = '/ionline/finances/dte/carga_manual';
    public $reception = ['dte_type' => ''];
    public $montoExento;
    public $montoTotal;
    public $montoNeto;
    public $montoIva;
    public $folio;
    public $razonSocial;
    public $emisor;
    public $authority = false;
    public $signer_id;
    public $signer_ou_id;
    public $approvals = [];
    public $items = [];
    public $showFacturaElectronicaFields = false;
    public $showFacturaExentaFields = false;
    public $readonly = true;
    public $showAllFields = false;

    public $receptionItems = [];
    public $exento = false;
    

    protected $rules = [        
        'reception.dte_type' => 'required',
        'reception.reception_type_id' => 'required',
        'reception.date'            => 'required|date_format:Y-m-d',
        'reception.dte_date'            => 'required|date_format:Y-m-d',
        'approvals'                 => 'required|array|min:1',
        'razonSocial'               => 'required',
        'emisor'               => 'required',
        'items.*.producto'                 => 'required|string',
        'items.*.unidad'                 => 'required|string',
        'items.*.cantidad'                 => 'required|numeric',
        'items.*.precioNeto'                 => 'numeric',
        'items.*.precioExento'                 => 'numeric',
        'items.*.total'                 => 'required|numeric',
        'montoTotal' => 'required|numeric',
    ];

    public $tipoDocumentoMap = [
        'factura_exenta' => 34,
        'factura_electronica' => 33,
        'guias_despacho' => 52,
        'nota_credito' => 61,
        'boleta_electronica' => 77,
        'boleta_honorarios' => 69,

        //hacer un distinct o algo para buscar los demas o buscar en la documentacion del SII
    ];


    public function render()
    {
        
        return view('livewire.finance.receptions.create-reception-no-oc');
    }


    public function mount()
    {
        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();
        
        if( array_key_exists('dte_id', $_GET) ) {
            $this->selectedDteId = $_GET['dte_id'];
            $dteData = Dte::find($this->selectedDteId);
            $this->emisor = $dteData->emisor;
            $this->folio = $dteData->folio;
            $this->reception['dte_type'] = $dteData->tipo_documento;
            $this->razonSocial = $dteData->razon_social_emisor;
            $this->reception['dte_date'] = $dteData->emision?->format('Y-m-d');
            $this->montoNeto = $dteData->monto_neto;
            $this->montoExento = $dteData->monto_exento;
            $this->montoIva = $dteData->monto_iva;
            $this->montoTotal = $dteData->monto_total;
            
        }
    }

    public function loadDteData()
    {
        if($this->reception['dte_type'] )
        {    
            
            if($this->emisor)
            {
            $value = preg_replace('/[^0-9K]/', '', strtoupper(trim($this->emisor)));
            $dv = substr($value, -1);
            $id = substr($value, 0, -1);
            $this->emisor = number_format($id, 0, '', '.').'-'.$dv;
    
            $dteData = Dte::where('emisor', $this->emisor)
                            ->where('folio', $this->folio)
                            ->where('tipo_documento', $this->reception['dte_type'])
                            ->first();
    
                if ($dteData) {
                    $this->razonSocial = $dteData->razon_social_emisor;
                    $this->reception['dte_date'] = $dteData->emision?->format('Y-m-d');
                    $this->montoNeto = $dteData->monto_neto;
                    $this->montoExento = $dteData->monto_exento;
                    $this->montoIva = $dteData->monto_iva;
                    $this->montoTotal = $dteData->monto_total;
                }
            }
        }
    }
    

    public function save()
    {        
        
        $this->validate();
        $tipo = $this->tipoDocumentoMap[$this->reception['dte_type']];

        $value = preg_replace('/[^0-9K]/', '', strtoupper(trim($this->emisor)));
        $dv = substr($value, -1);
        $id = substr($value, 0, -1);
        $this->emisor = number_format($id, 0, '', '.').'-'.$dv;

        $existingDte = Dte::where('tipo_documento', $this->reception['dte_type'])
        ->where('folio', $this->folio)
        ->where('emisor', $this->emisor)
        ->first();


        if ($existingDte) {
            $dte_manual = $existingDte;
        } else {
            // Si no existe, crear un nuevo registro en la tabla Dte
            $dte_manual = Dte::create([
                'tipo_documento' => $this->reception['dte_type'],
                'folio' => $this->folio,
                'emisor' => $this->emisor,
                'emision' => $this->reception['dte_date'],
                'razon_social_emisor' => $this->razonSocial,
                'monto_neto' => isset($this->montoNeto) ? $this->montoNeto : null,
                'monto_exento' => isset($this->montoExento) ? $this->montoExento : null,
                'monto_iva' => isset($this->montoIva) ? $this->montoIva : null,
                'monto_total' => $this->montoTotal,
                'tipo' => $tipo,
                'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
            ]);
        }

        
        
        $receptionData = [
            'reception_type_id' => $this->reception['reception_type_id'],
            'date' => $this->reception['date'],
            'creator_id' => auth()->user()->id,
            'creator_ou_id' => auth()->user()->organizational_unit_id,
            'responsable_id' => auth()->user()->id,
            'responsable_ou_id' => auth()->user()->organizational_unit_id,
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
            'dte_type' => $this->reception['dte_type'],
            'dte_number' => $this->folio,
            'dte_date' => $this->reception['dte_date'],
            'header_notes' => $this->reception['header_notes'] ?? null,
            'neto' => isset($this->montoNeto) ? $this->montoNeto : null,
            'subtotal' => isset($this->montoNeto) ? $this->montoNeto : null,
            'iva' => isset($this->montoIva) ? $this->montoIva : null,
            'total' => $this->montoTotal,
        ];
    
        // Determinar qué campo utilizar para el ID del documento
        if ($this->reception['dte_type'] === 'guias_despacho') {
            $receptionData['guia_id'] = $dte_manual->id;
        } else {
            $receptionData['dte_id'] = $dte_manual->id;
        }
    
        $reception = Reception::create($receptionData);
        

        foreach ($this->items as $index => $item) {
            ReceptionItem::create([
                'reception_id' => $reception->id,
                'item_position' => $index,
                'Producto' => $item['producto'],
                'Unidad' => $item['unidad'],
                'Cantidad' => $item['cantidad'],
                'PrecioNeto' => !empty($item['precioNeto']) ? $item['precioNeto'] : null,
                'PrecioExento' => !empty($item['precioExento']) ? $item['precioExento'] : null,
                'Total' => $item['total'],
                
            ]);
        }

        if($this->digitalInvoiceFile) {
            $storage_path = 'ionline/finances/receptions/no_oc';
            $filename = $reception->id.'.pdf';

            $this->digitalInvoiceFile->storeAs($storage_path, $filename);

            $reception->files()->create([
                'storage_path' => $storage_path.'/'.$filename,
                'stored' => true,
                'type' => 'no_oc',
                'stored_by_id' => auth()->id(),
            ]);
        }

        $priorityOrder = ['left', 'center', 'right'];
        foreach($priorityOrder as $element) {
            if(key_exists($element,$this->approvals)) {
                $approvalsOrderedByPriority[] = $this->approvals[$element];
            }
        }


        if( array_key_exists('sent_to_user_id', end($approvalsOrderedByPriority) ) ) {
            $this->reception['responsable_id'] = end($approvalsOrderedByPriority)['sent_to_user_id'];
            $this->reception['responsable_ou_id'] = User::find($this->reception['responsable_id'])->organizational_unit_id;
        }
        else {
            /* Si la ultima firma fue enviada a una OU */
            $this->reception['responsable_ou_id'] = end($approvalsOrderedByPriority)['sent_to_ou_id'];
        }


        


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



        session()->flash('success', 'Su acta sin OC fue creada exitosamente.');
        // $this->dispatch('documentTypeChanged', dte_type: $this->reception['dte_type']);
        return redirect()->route('finance.receptions.index');

    }


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
            $this->approvals[$position]['signerShortName'] = (User::find($user_id) ?? $this->signer_id)->shortName;
        }
        else if($this->signer_ou_id) {
            $this->approvals[$position]['sent_to_ou_id']   = $this->signer_ou_id;
            $this->approvals[$position]['signerShortName'] = $this->authority;
        }
    }

    #[On('setTemplate')]
    public function setTemplate($input, $template)
    {
        $this->$input = $template;
    }

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

    #[On('userSelected')]
    public function userSelected(User $user)
    {
        $this->signer_id = $user;
    }

    public function removeApproval($position)
    {
        unset($this->approvals[$position]);
    }

    public function addItem()
    {
        $exento = $this->showFacturaExentaFields;

        $this->items[] = [
            'producto' => '',
            'cantidad' => '',
            'unidad' => '',
            'precioNeto' => '',
            'precioExento' => '',
            'total' => 0,
            'exento' => $exento,
        ];

        $this->calculateTotal(count($this->items) - 1);
    }
    

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function calculateTotal($index)
    {
        $item = $this->items[$index];
        if (!empty($item['cantidad'])) {
            if (!empty($item['precioExento']) && $item['exento']) {
                // Si hay un monto exento definido y el ítem es exento, calcular el total usando el monto exento
                $this->items[$index]['total'] = $item['cantidad'] * $item['precioExento'];
            } elseif (!empty($item['precioNeto']) && !$item['exento']) {
                // Si no hay monto exento pero hay un precio neto, calcular el total usando el precio neto
                $this->items[$index]['total'] = $item['cantidad'] * $item['precioNeto'];
            }
        }
    }
    

    public function calculateTotalAmount()
    {
        $neto = $this->montoNeto ?? 0;
        $exento = $this->montoExento ?? 0;
        $iva = $this->showFacturaElectronicaFields ? ($this->montoIva ?? 0) : 0;
        $this->montoTotal = $neto + $iva + $exento;
    }

    public function toggleFacturaElectronicaFields($value)
    {
        $this->showFacturaElectronicaFields = $value === 'factura_electronica';
        $this->showFacturaExentaFields = $value === 'factura_exenta';
        $this->readonly = $value !== 'boleta_electronica';
        $this->showAllFields = $value === 'guias_despacho';

        if ($value === 'factura_exenta') {
            // Marcar todos los ítems como exentos
            foreach ($this->items as &$item) {
                $item['exento'] = true;
            }
        }


        $this->loadDteData();
    }



    public function preview()
    {
        
    }

    public function toggleExento($index)
    {
        $this->items[$index]['exento'] = !$this->items[$index]['exento'];
        $this->calculateTotal($index); // recalcular el total cuando se cambia el estado de exento
        
    }
    
}