<?php

namespace App\Http\Livewire\Finance\Receptions;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Finance\Receptions\ReceptionType;
use App\Models\Finance\Dte;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\Receptions\ReceptionItem;
use App\User;
use App\Rrhh\OrganizationalUnit;

class CreateReceptionNoOc extends Component
{
    use WithFileUploads;

    public $digitalInvoiceFile;
    public $additionalField;
    public $types;
    public $storage_path = '/ionline/finances/dte/carga_manual';
    public $reception = ['dte_type' => ''];
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
    

    protected $rules = [
        'digitalInvoiceFile' => 'required|file|max:2048',
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
        'items.*.precioNeto'                 => 'required|numeric',
        'items.*.total'                 => 'required|numeric',
        'montoNeto' => 'required|numeric',
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

    protected $listeners = ['userSelected', 'ouSelected', 'setTemplate'];



    public function render()
    {
        return view('livewire.finance.receptions.create-reception-no-oc');
    }


    public function mount()
    {
        $this->types = ReceptionType::where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
            ->pluck('name','id')->toArray();
    }

    public function save()
    {        
        
        $this->validate();
        $tipo = $this->tipoDocumentoMap[$this->reception['dte_type']];

        $value = preg_replace('/[^0-9K]/', '', strtoupper(trim($this->emisor)));
        $dv = substr($value, -1);
        $id = substr($value, 0, -1);
        $this->emisor = number_format($id, 0, '', '.').'-'.$dv;

        $dte_manual = Dte::create([
            
            'tipo_documento' => $this->reception['dte_type'],
            'folio' => $this->folio,
            'emisor' => $this->emisor,
            'emision' => $this->reception['dte_date'],
            'razon_social_emisor' => $this->razonSocial,
            'monto_neto' => isset($this->montoNeto) ? $this->montoNeto : null,
            'monto_iva' => isset($this->montoIva) ? $this->montoIva : null,
            'monto_total' => $this->montoTotal,
            'tipo' => $tipo,
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
        ]);

        
        
        $reception = Reception::create([
            'reception_type_id' => $this->reception['reception_type_id'],
            'date' => $this->reception['date'],
            'creator_id' => auth()->user()->id,
            'creator_ou_id' => auth()->user()->organizational_unit_id,
            'responsable_id' => auth()->user()->id,
            'responsable_ou_id' => auth()->user()->organizational_unit_id,
            'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
            'dte_id' => $dte_manual->id,
            'dte_type' => $this->reception['dte_type'],
            'dte_number' => $this->folio,
            'dte_date' => $this->reception['dte_date'],
            'header_notes' => $this->reception['header_notes'] ?? null,
            'neto' => isset($this->montoNeto) ? $this->montoNeto : null,
            'subtotal' => isset($this->montoNeto) ? $this->montoNeto : null,
            'iva' => isset($this->montoIva) ? $this->montoIva : null,
            'total' => $this->montoTotal,
        ]);
        

        foreach ($this->items as $item) {
            ReceptionItem::create([
                'reception_id' => $reception->id,
                'Producto' => $item['producto'],
                'Unidad' => $item['unidad'],
                'Cantidad' => $item['cantidad'],
                'PrecioNeto' => $item['precioNeto'],
                'Total' => $item['total'],
            ]);
        }

        if($this->digitalInvoiceFile) {
            $storage_path = 'ionline/finances/receptions/no_oc';
            $filename = $reception->id.'.pdf';

            $this->digitalInvoiceFile->storeAs($storage_path, $filename, 'gcs');

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
        $this->emit('documentTypeChanged', $this->reception['dte_type']);
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
            $this->approvals[$position]['signerShortName'] = User::find($user_id ?? $this->signer_id)->shortName;
        }
        else if($this->signer_ou_id) {
            $this->approvals[$position]['sent_to_ou_id']   = $this->signer_ou_id;
            $this->approvals[$position]['signerShortName'] = $this->authority;
        }
    }

    public function setTemplate($input, $template)
    {
        $this->$input = $template;
    }

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

    public function userSelected($user_id)
    {
        $this->signer_id = $user_id;
    }

    public function removeApproval($position)
    {
        unset($this->approvals[$position]);
    }

    public function addItem()
    {
        $this->items[] = [
            'producto' => '',
            'cantidad' => '',
            'unidad' => '',
            'precioNeto' => '',
            'total' => 0,
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
        if (!empty($item['cantidad']) && !empty($item['precioNeto'])) {
            $this->items[$index]['total'] = $item['cantidad'] * $item['precioNeto'];
            return $this->items[$index]['total'];
        }
        return 0;
    }

    public function calculateTotalAmount()
    {
        $neto = $this->montoNeto ?? 0;
        $iva = $this->showFacturaElectronicaFields ? ($this->montoIva ?? 0) : 0;
        $this->montoTotal = $neto + $iva;
    }

    public function toggleFacturaElectronicaFields($value)
    {
        $this->showFacturaElectronicaFields = $value === 'factura_electronica';
    }



}
