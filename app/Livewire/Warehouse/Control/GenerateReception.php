<?php

namespace App\Livewire\Warehouse\Control;

use App\Http\Requests\Warehouse\Control\AddProductRequest;
use App\Http\Requests\Warehouse\Control\GenerationReceptionRequest;
use App\Models\Parameters\Program;
use App\Models\ClCommune;
use App\Models\Documents\Approval;
use App\Models\Parameters\Supplier;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\PurchasingProcessDetail;
use App\Models\RequestForms\RequestForm;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\TypeReception;
use App\Models\WebService\MercadoPublico;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\User;


class GenerateReception extends Component
{
    public $store;
    public $po_search;
    public $msg = null;
    public $error = false;

    public $purchaseOrder;
    public $date;
    public $note;
    public $program_id;
    public $request_form_id;
    public $request_form;
    public $has_code_unspsc;
    public $technical_signer_id;
    public $technical_signature;
    public $disabled_program;
    public $po_code;
    public $po_date;
    public $document_number;
    public $document_date;
    public $document_type;
    public $supplier_name;
    public $branch_code;
    public $branch_name;
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    public $contact_charge;
    public $require_contract_manager_visation = false;

    public $search_product;
    public $index_selected;
    public $search_unspsc_code;
    public $unspsc_product_id;
    public $unspsc_product_code;
    public $unspsc_product_name;
    public $product_name;
    public $wre_product_id;
    public $wre_product_name;
    public $type_product_unspsc;

    public $description;
    public $barcode;
    public $quantity;
    public $max_quantity;

    public $po_items;
    public $programs;

    public $type_product;
    public $wre_products;

    public function render()
    {
        return view('livewire.warehouse.control.generate-reception');
    }

    public function mount()
    {
        $this->type_product = 1;
        $this->programs = $this->getPrograms();
        $this->wre_products = collect([]);
        $this->po_items = [];
        $this->error = false;
        $this->request_form_id = null;
    }

    public function rules()
    {
        return (new AddProductRequest($this->store->id, $this->max_quantity, $this->type_product))->rules();
    }

    public function getRulesReception()
    {
        return (new GenerationReceptionRequest)->rules();
    }

    public function getPurchaseOrder()
    {
        $this->error = false;
        $this->msg = '';
        $this->po_items = [];
        $this->resetInputReception();
        $this->resetInputProduct();

        $this->validate([
            'po_search' => 'required'
        ]);

        try {
            $purchaseOrder = MercadoPublico::getPurchaseOrder($this->po_search);
        } catch (\Throwable $th) {
            $this->error = true;
            $this->msg = $th->getMessage();
        }

        // if (isset($purchaseOrder) && $purchaseOrder->charges != 0) {
        //     $this->error = true;
        //     $this->msg = 'La OC posee cargos asociados.';
        //     $this->resetInputReception();
        // }

        if (!$this->error) {
            foreach ($purchaseOrder->items as $item) {
                $quantity = $this->getMaxQuantity($this->po_search, $item->Correlativo, $item->Cantidad);

                if ($quantity > 0) {
                    $wre_product_id = $this->getWreProductId($this->po_search, $item->Correlativo);
                    $wre_product = $wre_product_id ? Product::find($wre_product_id) : null;

                    $infoItem['unit_price'] = $item->PrecioNeto;
                    $infoItem['correlative_po'] = $item->Correlativo;
                    $infoItem['quantity'] = $quantity;
                    $infoItem['max_quantity'] = $quantity;
                    $infoItem['po_quantity'] = $item->Cantidad;
                    $infoItem['description'] = $item->EspecificacionComprador;
                    $infoItem['barcode'] = $wre_product ? $wre_product->barcode : null;
                    $infoItem['product_name'] = $item->Producto;
                    $infoItem['unspsc_product_code'] = $this->getUnspscProductCode($wre_product, $item->CodigoProducto);
                    $infoItem['unspsc_product_name'] = $this->getUnspscProductName($infoItem['unspsc_product_code'], $item->Producto);
                    $infoItem['has_code_unspsc'] = ($infoItem['unspsc_product_code']) ? true : false;
                    $infoItem['can_edit'] = $this->getUnspscProductCode($wre_product, $item->CodigoProducto) == null ? true : false;
                    $infoItem['unspsc_product_id'] = null;
                    $infoItem['wre_product_id'] = $wre_product_id;
                    $infoItem['disabled_wre_product'] = ($wre_product == null) ? false : true;
                    $infoItem['wre_product_name'] = $wre_product ? $wre_product->name : null;
                    $infoItem['type_product'] = ($wre_product == null) ? 1 : 0;
                    $this->po_items[] = $infoItem;
                }
            }

            $this->purchaseOrder = $purchaseOrder;
            $this->date = now()->format('Y-m-d');
            $this->error = false;
            $this->po_code = $purchaseOrder->code;
            $this->po_date = $purchaseOrder->date->format('Y-m-d H:i:s');
            $this->supplier_name = $purchaseOrder->supplier_name;
            $this->request_form_id = $this->getRequestFormId();
            $this->program_id = $this->getProgramId();
            $this->disabled_program = $this->program_id ? true : false;
            $this->technical_signer_id = $this->getTechnicalSignatureId();

            /**
             * No permite generar ingreso donde los productos ya fueron recepcionados
             */
            if (count($this->po_items) == 0) {
                $this->error = true;
                $this->msg = 'Todos los productos de la orden de compra fueron ingresados en bodega.';
                $this->resetInputReception();
            }

            /**
             * Muestra aviso si la orden de compra contiene productos sin código de producto ONU
             */
            if ($this->containsProductsWithoutUnspscCode($purchaseOrder->items)) {
                session()->flash('danger', 'La Orden de Compra contiene productos sin Código de Producto ONU.');
            }

            /**
             * La OC debe tener un FR relacionado.
             * No se admite OC sin FR.
             * Se debe relacionar el FR a la OC en caso de no tener FR.
             */
            if (!isset($this->request_form) && !$this->error) {
                session()->flash('danger', 'No existe ningún proceso de compra para la OC ingresada. Contácte a abastecimiento.');
            }
        }
    }

    public function getProgramId()
    {
        if ($this->request_form && $this->request_form->associateProgram) {
            $program_id = $this->request_form->associateProgram->id;
        } else {
            $control = Control::wherePoCode($this->po_search)->first();
            $program_id = null;
            if ($control)
                $program_id = $control->program_id;
        }
        return $program_id;
    }

    public function getMaxQuantity($po_code, $correlative_po, $quantity)
    {
        $quantity_enable = $quantity;

        $controlItem = ControlItem::query()
            ->whereHas('control', function ($query) use ($po_code) {
                $query->wherePoCode($po_code)->whereType(1);
            })
            ->whereCorrelativePo($correlative_po)
            ->latest()
            ->first();

        if ($controlItem)
            $quantity_enable = $quantity - $controlItem->balance;

        return $quantity_enable;
    }

    public function getWreProductId($po_code, $correlative_po)
    {
        $wre_product_id = null;
        $controlItem = ControlItem::query()
            ->whereHas('control', function ($query) use ($po_code) {
                $query->whereStoreId($this->store->id)->wherePoCode($po_code)->whereType(1);
            })
            ->whereCorrelativePo($correlative_po)
            ->latest()
            ->first();

        if ($controlItem)
            $wre_product_id = $controlItem->product_id;

        return $wre_product_id;
    }

    public function getUnspscProductCode($wre_product, $product_code)
    {
        if ($wre_product)
            $unspsc_product_code = $wre_product->product->code;
        else
            $unspsc_product_code = ($product_code == 0) ? null : $product_code;
        return $unspsc_product_code;
    }

    public function getUnspscProductName($unspsc_product_code, $product_name)
    {
        $unspsc_product = UnspscProduct::whereCode($unspsc_product_code)->first();
        if ($unspsc_product)
            $unspsc_product_name = $unspsc_product->name;
        else
            $unspsc_product_name = $product_name;
        return $unspsc_product_name;
    }

    public function getSupplier($run)
    {
        $supplier = Supplier::whereRun($run);
        $commune = ClCommune::whereName($this->purchaseOrder->supplier_commune)->first();

        if ($supplier->exists()) {
            $supplier = $supplier->first();
            $supplier->update([
                'code' => ($supplier->code == null) ? $this->purchaseOrder->supplier_code : $supplier->code,
                'branch_code' => ($supplier->branch_code == null) ? $this->purchaseOrder->supplier_branch_code : $supplier->branch_code,
                'branch_name' => ($supplier->branch_name == null) ? $this->purchaseOrder->supplier_branch_name : $supplier->branch_name,
                'contact_name' => ($supplier->contact_name == null) ? $this->purchaseOrder->supplier_contact_name : $supplier->contact_name,
                'contact_charge' => ($supplier->contact_charge == null) ? $this->purchaseOrder->supplier_contact_charge : $supplier->contact_charge,
                'contact_phone' => ($supplier->contact_phone == null) ? $this->purchaseOrder->supplier_contact_phone : $supplier->contact_phone,
                'contact_email' => ($supplier->contact_email == null) ? $this->purchaseOrder->supplier_contact_email : $supplier->contact_email,
                'commercial_activity' => ($supplier->commercial_activity == null) ? $this->purchaseOrder->supplier_commercial_activity : $supplier->commercial_activity,
                'address' => ($supplier->address == null) ? $this->purchaseOrder->supplier_address : $supplier->address,
                'commune_id' => ($supplier->commune_id == null && $commune) ? $commune->id : $supplier->commune_id,
                'region_id' => ($supplier->region_id == null && $commune) ? $commune->region->id : $supplier->region_id,
            ]);
        } else {
            $supplier = Supplier::create([
                'run' => $this->purchaseOrder->supplier_rut,
                'dv' => $this->purchaseOrder->supplier_dv,
                'code' => $this->purchaseOrder->supplier_code,
                'name' => $this->purchaseOrder->supplier_name,
                'branch_name' => $this->purchaseOrder->supplier_branch_name,
                'branch_code' => $this->purchaseOrder->supplier_branch_code,
                'contact_name' => $this->purchaseOrder->supplier_contact_name,
                'contact_charge' => $this->purchaseOrder->supplier_contact_charge,
                'contact_phone' => $this->purchaseOrder->supplier_contact_phone,
                'contact_email' => $this->purchaseOrder->supplier_contact_email,
                'commercial_activity' => $this->purchaseOrder->supplier_commercial_activity,
                'address' => $this->purchaseOrder->supplier_address,
                'commune_id' => $commune ? $commune->id : null,
                'region_id' => $commune ? $commune->region->id : null,
            ]);
        }
        return $supplier;
    }

    public function getRequestFormId()
    {
        $this->request_form = null;

        if (isset(ImmediatePurchase::wherePoId($this->po_search)->first()->requestForm)) {
            $requestForm = ImmediatePurchase::wherePoId($this->po_search)->first()->requestForm;
            $this->request_form = $requestForm;
        }

        return isset($this->request_form) ? $this->request_form->id : null;
    }

    public function getTechnicalSignatureId()
    {
        $this->technical_signature = null;
        $technical_signer_id = null;

        if ($this->request_form && $this->request_form->contractManager) {
            $technical_signer_id = $this->request_form->contractManager->id;
            $this->technical_signature = $this->request_form->contractManager;
        }

        return $technical_signer_id;
    }

    public function getPrograms()
    {
        $programs = Program::query()
            ->orderByDesc('period')
            ->orderBy('name')
            ->onlyValid()
            ->get(['id', 'name', 'period']);

        return $programs;
    }

    public function editProduct($index)
    {
        $this->type_product_unspsc = 'select-product-unspsc';

        $this->index_selected = $index;
        $this->max_quantity = $this->po_items[$index]['max_quantity'];
        $this->quantity = $this->po_items[$index]['quantity'];
        $this->description = $this->po_items[$index]['description'];
        $this->barcode = $this->po_items[$index]['barcode'];
        $this->product_name = $this->po_items[$index]['product_name'];
        $this->unspsc_product_name = $this->po_items[$index]['unspsc_product_name'];
        $this->unspsc_product_code = $this->po_items[$index]['unspsc_product_code'];
        $this->unspsc_product_id = $this->po_items[$index]['unspsc_product_id'];
        $this->has_code_unspsc = $this->po_items[$index]['has_code_unspsc'];
        $this->wre_product_id = $this->po_items[$index]['wre_product_id'];
        $this->wre_product_name = $this->po_items[$index]['wre_product_name'];

        if ($this->po_items[$index]['disabled_wre_product'] == false)
            $this->type_product = $this->po_items[$index]['type_product'];
        else
            $this->type_product = 0;
    }

    public function updateProduct()
    {
        $dataValidated = $this->validate();

        if ($this->barcodeExists($this->po_items, $dataValidated['barcode'], $this->index_selected))
            throw ValidationException::withMessages(['barcode' => '.El campo código de barra ya ha sido registrado.']);

        $this->po_items[$this->index_selected]['quantity'] = $dataValidated['quantity'];
        $this->po_items[$this->index_selected]['description'] = $dataValidated['description'];
        $this->po_items[$this->index_selected]['barcode'] = $dataValidated['barcode'];
        $this->po_items[$this->index_selected]['unspsc_product_id'] = $this->unspsc_product_id;
        $this->po_items[$this->index_selected]['unspsc_product_code'] = $this->unspsc_product_code;
        $this->po_items[$this->index_selected]['unspsc_product_name'] = $this->getUnspscProductName($this->unspsc_product_code, $this->po_items[$this->index_selected]['product_name']);
        $this->po_items[$this->index_selected]['has_code_unspsc'] = ($this->unspsc_product_code == null) ? false : true;
        $this->po_items[$this->index_selected]['wre_product_id'] = $this->wre_product_id;
        $this->po_items[$this->index_selected]['wre_product_name'] = $this->wre_product_name;

        if ($this->po_items[$this->index_selected]['disabled_wre_product'] == false)
            $this->po_items[$this->index_selected]['type_product'] = $this->type_product;

        $this->resetInputProduct();
    }

    public function updatedSearchProduct()
    {
        $wre_products = collect([]);
        $this->wre_product_id = null;
        $this->wre_product_name = null;

        if ($this->search_product) {
            $search = "%$this->search_product%";
            $wre_products = Product::query()
                ->whereStoreId($this->store->id)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', $search)
                        ->orWhere('barcode', 'like', $search)
                        ->orWhereHas('product', function ($query) use ($search) {
                            $query->where('name', 'like', $search);
                        });
                })
                ->whereStoreId($this->store->id)
                ->get();
        }

        $this->wre_products = $wre_products;
    }

    public function searchUnspscCode()
    {
        if (Str::length($this->search_unspsc_code) == 8) {
            $unspscProduct = UnspscProduct::whereCode($this->search_unspsc_code)->first();

            $this->unspsc_product_id = $unspscProduct->id;
            $this->unspsc_product_code = $unspscProduct->code;
            $this->unspsc_product_name = $unspscProduct->name;
        } else {
            $this->unspsc_product_id = null;
            $this->unspsc_product_code = null;
            $this->unspsc_product_name = $this->product_name;
        }
    }

    public function deleteUnspscCode()
    {
        $this->unspsc_product_id = null;
        $this->unspsc_product_code = null;
        $this->unspsc_product_name = $this->product_name;
    }

    public function updatedWreProductId($value)
    {
        if ($value != '') {
            $wre_product = Product::find($value);
            $this->wre_product_name = $wre_product->name;
            $this->barcode = $wre_product->barcode;
        }
    }

    public function barcodeExists($items, $barcode, $index)
    {
        unset($items[$index]);

        $newArray = array_filter($items, function ($item) {
            if ($item['barcode'] != null)
                return $item;
        }, ARRAY_FILTER_USE_BOTH);

        return in_array($barcode, array_column($newArray, 'barcode'));
    }

    public function quantityIsEqualToZero()
    {
        $newArray = array_filter($this->po_items, function ($item) {
            if ($item['quantity'] >= 1)
                return $item;
        }, ARRAY_FILTER_USE_BOTH);

        return (count($newArray) == 0) ? true : false;
    }

    public function finish()
    {
        $dataValidated = $this->validate($this->getRulesReception());
        if ($this->quantityIsEqualToZero())
            throw ValidationException::withMessages(['po_items' => 'Todos los productos de la orden de compra tienen cantidad en cero.']);

        if ($this->store->visator == null) {
            session()->flash('danger', 'Disculpe, la Bodega no tiene visador. Por favor agregue uno.');
            return;
        }

        $supplier = $this->getSupplier($this->purchaseOrder->supplier_rut);
        $program = Program::find($dataValidated['program_id']);

        $control = Control::create([
            'type' => true,
            'confirm' => true,
            'status' => true,
            'note' => $dataValidated['note'],
            'date' => $dataValidated['date'],
            'po_date' => Carbon::parse($dataValidated['po_date'])->format('Y-m-d H:i:s'),
            'po_code' => $dataValidated['po_code'],
            'document_type' => $dataValidated['document_type'],
            'document_number' => $dataValidated['document_number'],
            'document_date' => $dataValidated['document_date'],
            'type_reception_id' => TypeReception::purchaseOrder(),
            'store_id' => $this->store->id,
            'program_id' => $program ? $program->id : null,
            'supplier_id' => $supplier->id,
            'po_id' => $this->purchaseOrder->id,
            'request_form_id' => $this->request_form_id,
            'reception_visator_id' => auth()->id(),
            'technical_signer_id' => $this->technical_signer_id,
            'completed_invoices' => false,
            'require_contract_manager_visation' => $dataValidated['require_contract_manager_visation'],

        ]);


        // Realizar la prueba cuando vuelva MP        
        // if ($control->require_contract_manager_visation == 1 and $this->request_form) {
        //     $control->visation_contract_manager_user_id = $control->requestForm->contract_manager_id;
        //     $control->visation_contract_manager_ou = $control->requestForm->contract_manager_ou_id;
        //     $control->save();

        //     // Notificación al Usuaro administrador de contrato
        //     $user = User::findOrFail($control->visation_contract_manager_user_id);
        //     $user->notify(new \App\Notifications\Warehouse\VisationContractManager);
        // }

        // Proceso para notificar y guardar al jefe de bodega
        // Probar cuando vuelva MP

        // $user_warehouse = auth()->user()->boss;
        // $control->visation_warehouse_manager_user_id = $user_warehouse->id;
        // $control->visation_warehouse_manager_ou = $user_warehouse->id;
        // $user_warehouse->notify(new \App\Notifications\Warehouse\VisationContractManager);


        // Nueva versión Probar cuando llegue MP
        // if ($control->require_contract_manager_visation == 1 and $this->request_form){        
        //     $approval_contract_manager = Approval::create([
        //         "module" => "Modulo Bodega",
        //         "module_icon" => "fas fa-rocket",
        //         "subject" => "Nueva Solicitud de Visación de  Administrador de Contrato por parte de Bodega",                
        //         "approver_id" => $control->requestForm->contract_manager_id, 
        //     ]);
        // $this->chainApprovals($control->requestForm->contract_manager_id);
        // }


        foreach ($this->po_items as $item) {
            if ($item['wre_product_id'] == null && $item['quantity'] > 0) {
                $unspscProduct = UnspscProduct::whereCode($item['unspsc_product_code'])->first();
                $wreProduct = Product::create([
                    'barcode' => $item['barcode'],
                    'name' => $item['description'],
                    'unspsc_product_id' => $unspscProduct->id,
                    'store_id' => $this->store->id,
                ]);
            } else
                $wreProduct = Product::find($item['wre_product_id']);

            if ($item['quantity'] > 0) {
                $lastBalance = Product::lastBalance($wreProduct, $program);

                ControlItem::create([
                    'quantity' => $item['quantity'],
                    'balance' => $item['quantity'] + $lastBalance,
                    'confirm' => true,
                    'correlative_po' => $item['correlative_po'],
                    'unit_price' => $item['unit_price'],
                    'control_id' => $control->id,
                    'program_id' => $program ? $program->id : null,
                    'product_id' => $wreProduct->id,
                ]);
            }
        }

        $this->dispatch('clearSearchUser', false);
        $this->resetInputProduct();
        $this->resetInputReception();
        $this->po_search = null;
        $this->po_items = [];

        session()->flash('success', 'El nuevo ingreso fue guardado exitosamente.');
    }

    public function chainApprovals(Control $control, $contract_manager_visation_id = null)
    {
        $approval_contract_manager = null;
        if ($contract_manager_visation_id) {
            $approval_contract_manager = Approval::create([
                "module" => "Modulo Bodega",
                "module_icon" => "fas fa-rocket",
                "subject" => "Nueva Solicitud de Visación de  Administrador de Contrato por parte de Bodega",
                "approver_id" => $control->requestForm->contract_manager_id,
            ]);
        }

        if ($approval_contract_manager) {
            $approval_warehouse_manager = Approval::create([
                "module" => "Modulo Bodega",
                "module_icon" => "fas fa-rocket",
                "subject" => "Nueva Solicitud de Visación de  Administrador de Contrato por parte de Bodega",
                "approver_id" => auth()->user()->boss->id,
                "active" => false,
                "previous_approval_id" => $approval_contract_manager->id,
            ]);
        }
        else{
            $approval_warehouse_manager = Approval::create([
                "module" => "Modulo Bodega",
                "module_icon" => "fas fa-rocket",
                "subject" => "Nueva Solicitud de Visación de  Administrador de Contrato por parte de Bodega",
                "approver_id" => auth()->user()->boss->id,
            ]);

        }


        // Chequeo de si existe aprobacion de administrador de contrato

    }



    public function clearAll()
    {
        $this->po_search = null;
        $this->po_items = [];
        $this->msg = '';
        $this->error = false;
        $this->resetInputProduct();
        $this->resetInputReception();
    }

    public function resetInputProduct()
    {
        $this->index_selected = null;
        $this->max_quantity = 0;
        $this->quantity = 0;
        $this->description = null;
        $this->barcode = null;
        $this->has_code_unspsc = null;
        $this->search_unspsc_code = null;
        $this->unspsc_product_name = null;
        $this->unspsc_product_id = null;
        $this->unspsc_product_code = null;
        $this->wre_product_id = null;
        $this->wre_product_name = null;
        $this->search_product = null;
        $this->type_product = 1;
        $this->wre_products = collect([]);
    }

    public function resetInputReception()
    {
        $this->date = null;
        $this->supplier_name = null;
        $this->po_code = null;
        $this->po_date = null;
        $this->document_type = null;
        $this->document_number = null;
        $this->document_date = null;
        $this->program_id = null;
        $this->note = null;
        $this->request_form = null;
        $this->request_form_id = null;
        $this->technical_signature = null;
        $this->technical_signer_id = null;
        $this->disabled_program = false;
        $this->require_contract_manager_visation = false;
    }

    public function containsProductsWithoutUnspscCode($items)
    {
        $items = collect($items);

        $items = $items->contains(function ($value, int $key) {
            return $value->CodigoProducto == 0;
        });

        return $items;
    }
}
