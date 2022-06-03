<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Http\Requests\Warehouse\Control\AddProductRequest;
use App\Http\Requests\Warehouse\Control\GenerationReceptionRequest;
use App\Models\Parameters\Program;
use App\Models\ClCommune;
use App\Models\Inv\Inventory;
use App\Models\Parameters\Supplier;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\RequestForms\PurchasingProcessDetail;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\TypeReception;
use App\Models\WebService\MercadoPublico;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class GenerateReception extends Component
{
    public $store;
    public $po_search;
    public $error;
    public $msg;

    public $purchaseOrder;
    public $date;
    public $note;
    public $program_id;
    public $request_form_id;
    public $disabled_program;
    public $po_code;
    public $po_date;
    public $guide_number;
    public $guide_date;
    public $invoice_number;
    public $invoice_date;
    public $supplier_name;
    public $branch_code;
    public $branch_name;
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    public $contact_charge;

    public $search_product;
    public $index_selected;
    public $unspsc_product_name;
    public $unspsc_product_id;
    public $unspsc_product_code;
    public $wre_product_id;
    public $wre_product_name;

    public $description;
    public $barcode;
    public $quantity;
    public $max_quantity;

    public $po_items;
    public $programs;

    public $type_product;
    public $wre_products; // sin usar
    public $control_item_id; // sin usar

    public function render()
    {
        return view('livewire.warehouse.control.generate-reception');
    }

    public function mount()
    {
        $this->type_product = 1;
        $this->programs = Program::get(['id', 'name']);
        $this->wre_products = collect([]);
        $this->po_items = [];
        $this->error = false;
    }

    public function rules()
    {
        return (new AddProductRequest($this->store->id, $this->max_quantity))->rules();
    }

    public function getRulesReception()
    {
        return (new GenerationReceptionRequest)->rules();
    }

    public function getPurchaseOrder()
    {
        $this->validate([
            'po_search' => 'required'
        ]);

        $this->resetInputReception();
        $this->resetInputProduct();
        $this->error = false;
        $this->po_items = [];

        $purchaseOrder = MercadoPublico::getPurchaseOrder($this->po_search);

        if($purchaseOrder)
        {
            $this->purchaseOrder = $purchaseOrder;
            $this->date = now()->format('Y-m-d');
            $this->error = false;
            $this->po_code = $purchaseOrder->code;
            $this->po_date = $purchaseOrder->date;
            $this->supplier_name = $purchaseOrder->supplier_name;
            $this->program_id = $this->getProgramId($this->po_search);
            $this->disabled_program = $this->program_id ? true : false;
            $this->request_form_id = $this->getRequestFormId($this->po_search);

            foreach($purchaseOrder->items as $item)
            {
                $quantity = $this->getMaxQuantity($this->po_search, $item->Correlativo, $item->Cantidad);

                if($quantity > 0)
                {
                    $wre_product_id = $this->getWreProductId($this->po_search, $item->Correlativo);

                    $infoItem['price'] = $item->PrecioNeto;
                    $infoItem['correlative_po'] = $item->Correlativo;
                    $infoItem['quantity'] = $quantity;
                    $infoItem['max_quantity'] = $quantity;
                    $infoItem['po_quantity'] = $item->Cantidad;
                    $infoItem['description'] = $item->EspecificacionComprador;
                    $infoItem['barcode'] = $wre_product_id ? Product::find($wre_product_id)->barcode : null;
                    $infoItem['unspsc_product_name'] = $item->Producto;
                    $infoItem['unspsc_product_code'] = $item->CodigoProducto;
                    $infoItem['unspsc_product_id'] = null;
                    $infoItem['wre_product_id'] = $wre_product_id;
                    $infoItem['disabled_wre_product'] = ($wre_product_id == null) ? false : true;
                    $infoItem['wre_product_name'] = $wre_product_id ? Product::find($wre_product_id)->name : null;
                    $this->po_items[] = $infoItem;
                }
            }

            if(count($this->po_items) == 0)
            {
                $this->error = true;
                $this->msg = 'Todos los productos de la orden de compra fueron recibidos.';
                $this->resetInputReception();
            }
        }
        else
        {
            $this->error = true;
            $this->msg = 'Disculpe, no pudimos obtener los datos de la orden de compra, intente nuevamente.';
        }
    }

    public function getProgramId($po_code)
    {
        $control = Control::wherePoCode($po_code)->first();
        $program_id = null;
        if($control)
            $program_id = $control->program_id;
        return $program_id;
    }

    public function getMaxQuantity($po_code, $correlative_po, $quantity)
    {
        $quantity_enable = $quantity;

        $controlItem = ControlItem::query()
            ->whereHas('control', function($query) use($po_code) {
                $query->wherePoCode($po_code)->whereType(1);
            })
            ->whereCorrelativePo($correlative_po)
            ->latest()
            ->first();

        if($controlItem)
            $quantity_enable = $quantity - $controlItem->balance;

        return $quantity_enable;
    }

    public function getWreProductId($po_code, $correlative_po)
    {
        $wre_product_id = null;
        $controlItem = ControlItem::query()
            ->whereHas('control', function($query) use($po_code) {
                $query->whereStoreId($this->store->id)->wherePoCode($po_code)->whereType(1);
            })
            ->whereCorrelativePo($correlative_po)
            ->latest()
            ->first();

        if($controlItem)
            $wre_product_id = $controlItem->product_id;

        return $wre_product_id;
    }

    public function getSupplier($run)
    {
        $supplier = Supplier::whereRun($run);
        $commune = ClCommune::whereName($this->purchaseOrder->supplier_commune)->first();

        if($supplier->exists())
        {
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
        }
        else
        {
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

    public function getRequestFormId($code)
    {
        $request_form_id = null;
        $immediatePurchase = ImmediatePurchase::wherePoId($code)->first();
        if($immediatePurchase)
        {
            $purchasingDetail = PurchasingProcessDetail::whereImmediatePurchaseId($immediatePurchase->id)->first();
            if($purchasingDetail)
            {
                $purchasingProcess = PurchasingProcess::find($purchasingDetail->purchasing_process_id);
                if($purchasingProcess)
                    $request_form_id = $purchasingProcess->request_form_id;
            }
        }
        return $request_form_id;
    }

    public function editProduct($index)
    {
        $this->index_selected = $index;
        $this->max_quantity = $this->po_items[$index]['max_quantity'];
        $this->quantity = $this->po_items[$index]['quantity'];
        $this->description = $this->po_items[$index]['description'];
        $this->barcode = $this->po_items[$index]['barcode'];
        $this->unspsc_product_name = $this->po_items[$index]['unspsc_product_name'];
        $this->unspsc_product_code = $this->po_items[$index]['unspsc_product_code'];
        $this->unspsc_product_id = $this->po_items[$index]['unspsc_product_id'];
        $this->wre_product_id = $this->po_items[$index]['wre_product_id'];
        $this->wre_product_name = $this->po_items[$index]['wre_product_name'];
    }

    public function updateProduct()
    {
        $dataValidated = $this->validate();
        $copyPoItems = $this->po_items;
        unset($copyPoItems[$this->index_selected]);

        if(in_array($dataValidated['barcode'], array_column($copyPoItems, 'barcode')))
            throw ValidationException::withMessages(['barcode' => 'El campo código de barra ya ha sido registrado.']);

        $this->po_items[$this->index_selected]['quantity'] = $dataValidated['quantity'];
        $this->po_items[$this->index_selected]['description'] = $dataValidated['description'];
        $this->po_items[$this->index_selected]['barcode'] = $dataValidated['barcode'];
        $this->po_items[$this->index_selected]['unspsc_product_name'] = $this->unspsc_product_name;
        $this->po_items[$this->index_selected]['unspsc_product_id'] = $this->unspsc_product_id;
        $this->po_items[$this->index_selected]['wre_product_id'] = $this->wre_product_id;
        $this->po_items[$this->index_selected]['wre_product_name'] = $this->wre_product_name;
        $this->resetInputProduct();
    }

    public function updatedSearchProduct()
    {
        $wre_products = collect([]);
        $this->wre_product_id = null;
        $this->wre_product_name = null;

        if($this->search_product)
        {
            $search = "%$this->search_product%";
            $wre_products = Product::query()
                ->where('name', 'like', $search)
                ->orWhere('barcode', 'like', $search)
                ->orWhereHas('product', function ($query) use($search) {
                    $query->where('name', 'like', $search);
                })
                ->whereHas('store', function ($query) {
                    $query->whereStoreId($this->store->id);
                })
                ->get();
        }

        $this->wre_products = $wre_products;
    }

    public function updatedWreProductId($value)
    {
        if($value != '')
        {
            $wre_product = Product::find($value);
            $this->wre_product_name = $wre_product->name;
            $this->barcode = $wre_product->barcode;
        }
    }

    public function saveInventory(ControlItem $controlItem, $quantity, $price)
    {
        for($i = 0; $i < $quantity; $i++)
        {
            Inventory::create([
                'po_code'=> $controlItem->control->po_code,
                'po_date'=> $controlItem->control->po_date,
                'po_price'=> $price,
                'product_id' => $controlItem->product_id,
                'po_id' => $controlItem->control->po_id,
                'control_id' => $controlItem->control_id,
                'store_id' => $this->store->id,
                'request_form_id' => $controlItem->control->request_form_id
            ]);
        }
    }

    public function resetInputProduct()
    {
        $this->index_selected = null;
        $this->max_quantity = 0;
        $this->quantity = 0;
        $this->description = null;
        $this->barcode = null;
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
        $this->guide_number = null;
        $this->guide_date = null;
        $this->invoice_date = null;
        $this->invoice_number = null;
        $this->program_id = null;
        $this->note = null;
        $this->disabled_program = false;
    }

    public function finish()
    {
        $dataValidated = $this->validate($this->getRulesReception());
        $supplier = $this->getSupplier($this->purchaseOrder->supplier_rut);
        $program = Program::find($dataValidated['program_id']);

        $control = Control::create([
            'type' => true,
            'confirm' => true,
            'status' => false,
            'note' => $dataValidated['note'],
            'date' => $dataValidated['date'],
            'status' => true,
            'po_date' => Carbon::parse($dataValidated['po_date'])->format('Y-m-d H:i:s'),
            'po_code' => $dataValidated['po_code'],
            'invoice_number' => $dataValidated['invoice_number'],
            'invoice_date' => $dataValidated['invoice_date'],
            'guide_number' => $dataValidated['guide_number'],
            'guide_date' => $dataValidated['guide_date'],
            'type_reception_id' => TypeReception::purchaseOrder(),
            'store_id' => $this->store->id,
            'program_id' => $program ? $program->id : null,
            'supplier_id' => $supplier->id,
            'po_id' => $this->purchaseOrder->id,
            'request_form_id' => $this->request_form_id,
        ]);

        foreach($this->po_items as $item)
        {
            if($item['wre_product_id'] == null)
            {
                $unspscProduct = UnspscProduct::whereCode($item['unspsc_product_code'])->first();
                $wreProduct = Product::create([
                    'barcode' => $item['barcode'],
                    'name' => $item['description'],
                    'unspsc_product_id' => $unspscProduct->id,
                    'store_id' => $this->store->id,
                ]);
            }
            else
                $wreProduct = Product::find($item['wre_product_id']);

            $lastBalance = Product::lastBalance($wreProduct, $program);

            if($item['quantity'] > 0)
            {
                $controlItem = ControlItem::create([
                    'quantity' => $item['quantity'],
                    'balance' => $item['quantity'] + $lastBalance,
                    'confirm' => true,
                    'correlative_po' => $item['correlative_po'],
                    'control_id' => $control->id,
                    'program_id' => $program ? $program->id : null,
                    'product_id' => $wreProduct->id,
                ]);

                $this->saveInventory($controlItem, $item['quantity'], $item['price']);
            }
        }

        $this->po_search = null;
        $this->po_items = [];
        $this->resetInputProduct();
        $this->resetInputReception();
    }
}
