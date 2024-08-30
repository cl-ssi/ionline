<?php

namespace App\Livewire\Warehouse\Control;

use App\Models\Parameters\Program;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\TypeReception;
use Livewire\Attributes\On;
use Livewire\Component;

class ControlReviewProduct extends Component
{
    public $store;
    public $control;
    public $search_product;
    public $indexEdit;
    public $item_id;
    public $wre_product_id;
    public $selected_wre_product_id;
    public $selected_wre_product_name;
    public $selected_unspsc_product_name;
    public $unspsc_product_id;
    public $unspsc_product_name;
    public $description;
    public $barcode;
    public $quantity;
    public $quantity_received;
    public $quantity_return;
    public $generate_return;
    public $return_note;
    public $can_edit;
    public $type_wre_product;
    public $wre_products;
    public $items;
    public $nav;

    public function mount()
    {
        $this->items = $this->getItems();
        $this->productId = null;
        $this->generate_return = false;
        $this->indexEdit = null;
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-review-product');
    }

    public function rules()
    {
        return [
            'description'               => 'required|string|min:2|max:255',
            'unspsc_product_id'         => 'required|integer|exists:unspsc_products,id',
            'selected_wre_product_id'   => 'nullable|required_if:type_wre_product,2|exists:wre_products,id',
            'quantity_received'         => 'required|integer|min:0|max:' . $this->quantity
        ];
    }

    public function getRulesFinish()
    {
        return [
            'return_note' => 'nullable|required_if:generate_return,1',
        ];
    }

    public function getItems()
    {
        $items = $this->control->items;
        $arrayItems = [];

        foreach($items as $controlItem)
        {
            $item['quantity_return'] = 0;
            $item['quantity_received'] = $controlItem['quantity'];
            $item['quantity'] = $controlItem['quantity'];
            $item['item_id'] = $controlItem['id'];
            $item['wre_product_id'] = $controlItem->product->id;
            $item['unspsc_product_id'] = $controlItem->product->unspsc_product_id;
            $item['unspsc_product_name'] = $controlItem->product->product->name;
            $item['unspsc_product_code'] = $controlItem->product->product->code;
            $item['description'] = $controlItem->product->name;
            $item['program_name'] = $controlItem->program_name;
            $item['program_id'] = $controlItem->program_id;
            $item['barcode'] = $controlItem->product->barcode;
            $item['type_wre_product'] = ($controlItem->product->barcode == null) ? 1 : null; // 1:nuevo 2:seleccionar
            $item['can_edit'] = ($controlItem->product->barcode == null) ? true : false;
            $item['selected_wre_product_id'] = null;
            $item['selected_wre_product_name'] = null;
            $item['selected_unspsc_product_name'] = null;
            $item['status'] = $this->getStatus($item['quantity'], $item['quantity_received']);

            $arrayItems[] = $item;
        }
        return $arrayItems;
    }

    public function getStatus($quantity, $quantity_received)
    {
        if($quantity_received == 0)
            $status = 0;
        elseif($quantity_received < $quantity)
            $status = -1;
        elseif($quantity_received == $quantity)
            $status = 1;

        return $status;
    }

    public function getRecepcionStatus($status)
    {
        $reception_status = false;
        if($status == 0 || $status == -1)
            $reception_status = true;
        return $reception_status;
    }

    public function getLocalProduct($type_wre_product, $wre_product_id, $selected_wre_product_id, $description, $unspsc_product_id)
    {
        if($type_wre_product == null)
        {
            $localProduct = Product::find($wre_product_id);
            $localProduct->update([
                'name' => $description,
                'unspsc_product_id' => $unspsc_product_id
            ]);
        }
        else
        {
            switch ($type_wre_product)
            {
                case 1:
                    $localProduct = Product::create([
                        'name' => $description,
                        'unspsc_product_id' => $unspsc_product_id,
                        'store_id' => $this->store->id,
                    ]);
                    break;
                case 2:
                    $localProduct = Product::find($selected_wre_product_id);
                    $localProduct->update([
                        'name' => $description
                    ]);
                    break;
            }
        }
        return $localProduct;
    }

    public function getForeignProduct($type_wre_product, $wre_product_id, $barcode)
    {
        if($type_wre_product == null)
        {
            $foreignProduct = Product::query()
                ->whereStoreId($this->control->store_origin_id)
                ->whereBarcode($barcode)
                ->first();
        }
        else
        {
            $foreignProduct = Product::find($wre_product_id);
        }
        return $foreignProduct;
    }

    public function editProduct($index)
    {
        $this->search_product = null;

        $this->indexEdit = $index;
        $this->item_id = $this->items[$index]['item_id'];
        $this->type_wre_product = $this->items[$index]['type_wre_product'];
        $this->can_edit = $this->items[$index]['can_edit'];
        $this->selected_wre_product_id = $this->items[$index]['selected_wre_product_id'];
        $this->selected_wre_product_name = $this->items[$index]['selected_wre_product_name'];
        $this->wre_product_id = $this->items[$index]['wre_product_id'];
        $this->unspsc_product_id = $this->items[$index]['unspsc_product_id'];
        $this->unspsc_product_name = $this->items[$index]['unspsc_product_name'];
        $this->description = $this->items[$index]['description'];
        $this->barcode = $this->items[$index]['barcode'];
        $this->quantity = $this->items[$index]['quantity'];
        $this->quantity_received = $this->items[$index]['quantity_received'];
        $this->quantity_return = $this->items[$index]['quantity_return'];
        $this->selected_unspsc_product_name = $this->items[$index]['selected_unspsc_product_name'];

        $this->wre_products = Product::query()
            ->whereStoreId($this->store->id)
            ->whereUnspscProductId($this->unspsc_product_id)
            ->get();

        $this->dispatch('searchProduct',  $this->items[$index]['unspsc_product_name']);
        $this->dispatch('productId', $this->items[$index]['unspsc_product_id']);
    }

    public function updateProduct()
    {
        $dataValidated = $this->validate();

        $product = UnspscProduct::find($dataValidated['unspsc_product_id']);
        $selectedWreProduct =  ($dataValidated['selected_wre_product_id']) ? Product::find($dataValidated['selected_wre_product_id']) : null;

        $quantity = $this->items[$this->indexEdit]['quantity'];
        $quantity_received = $dataValidated['quantity_received'];
        $status = $this->getStatus($quantity, $quantity_received);

        $this->items[$this->indexEdit]['type_wre_product'] = $this->type_wre_product;
        $this->items[$this->indexEdit]['selected_wre_product_id'] = $dataValidated['selected_wre_product_id'];
        $this->items[$this->indexEdit]['unspsc_product_id'] = $selectedWreProduct ? $selectedWreProduct->product->id : $product->id;
        $this->items[$this->indexEdit]['unspsc_product_name'] = $selectedWreProduct ? $selectedWreProduct->product->name : $product->name;
        $this->items[$this->indexEdit]['description'] = $selectedWreProduct ? $selectedWreProduct->name : $dataValidated['description'];
        $this->items[$this->indexEdit]['quantity_received'] = $dataValidated['quantity_received'];
        $this->items[$this->indexEdit]['quantity_return'] = $quantity - $dataValidated['quantity_received'];
        $this->items[$this->indexEdit]['status'] = $status;

        $this->generate_return = $this->getRecepcionStatus($status);

        $this->control->refresh();
        $this->resetInput();
    }

    public function updatedSearchProduct()
    {
        $this->dispatch('searchProduct', $this->search_product);
    }

    #[On('myProductId')]
    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }

    public function resetInput()
    {
        $this->indexEdit = null;
        $this->item_id = null;
        $this->type_wre_product = null;
        $this->can_edit = null;
        $this->description = null;
        $this->wre_product_id = null;
        $this->unspsc_product_id = null;
        $this->unspsc_product_name = null;
        $this->barcode = null;
        $this->quantity = null;
        $this->quantity_received = null;

        $this->dispatch('onClearSearch');
        $this->dispatch('productId', null);
    }

    public function finish()
    {
        $dataValidated = $this->validate($this->getRulesFinish());

        if($this->generate_return)
        {
            $newControl = Control::create([
                'type' => 1,
                'date' => now(),
                'confirm' => true,
                'status' => false,
                'note' => $dataValidated['return_note'],
                'type_reception_id' => TypeReception::return(),
                'program_id' =>  $this->control->program_id,
                'store_id' => $this->control->store_origin_id,
                'store_origin_id' => $this->store->id,
            ]);
        }

        foreach($this->items as $item)
        {
            $program = $item['program_id'] ? Program::find($item['program_id']) : null;

            $localProduct = $this->getLocalProduct($item['type_wre_product'], $item['wre_product_id'],
                $item['selected_wre_product_id'], $item['description'], $item['unspsc_product_id']);

            $foreignProduct = $this->getForeignProduct($item['type_wre_product'], $item['wre_product_id'], $item['barcode']);

            $foreignBalance = Product::lastBalance($foreignProduct, $program);
            $localBalance = Product::lastBalance($localProduct, $program);

            $controlItem = ControlItem::find($item['item_id']);

            if(($item['status'] == -1 || $item['status'] == 0) && $this->generate_return)
            {
                ControlItem::create([
                    'balance' => $item['quantity_return'] + $foreignBalance,
                    'quantity' => $item['quantity_return'],
                    'confirm' => true,
                    'control_id' => $newControl->id,
                    'program_id' => $item['program_id'],
                    'product_id' => $foreignProduct->id,
                ]);
            }

            $this->updateProductId($controlItem, $localProduct, $item['type_wre_product']);
            $this->updateControlItem($controlItem, $item['status'], $item['quantity'], $item['quantity_received'], $localBalance);
        }

        $this->control->update([
            'confirm' => true,
            'status' => false,
        ]);

        session()->flash('success', "Se ha completado la revisión de la transferencia.");

        return redirect()->route('warehouse.controls.index', [
            'store' => $this->store,
            'control' => $this->control,
            'type' => 'receiving',
            'nav' => $this->nav,
        ]);
    }

    public function updateControlItem(ControlItem $controlItem, $status, $quantity, $quantity_received, $lastBalance)
    {
        switch($status)
        {
            case -1:
                $controlItem->update([
                    'balance' => $lastBalance + $quantity_received,
                    'quantity' => $quantity_received,
                    'confirm' => true,

                ]);
                break;
            case 1:
                $controlItem->update([
                    'balance' => $lastBalance + $quantity,
                    'quantity' => $quantity,
                    'confirm' => true,
                ]);
                break;
            case 0:
                $controlItem->update([
                    'confirm' => false,
                ]);
                break;
        }
    }

    public function updateProductId(ControlItem $controlItem, Product $localProduct, $type_wre_product)
    {
        if($type_wre_product == 2 || $type_wre_product == 1)
        {
            $controlItem->update([
                'product_id' => $localProduct->id,
            ]);
        }
    }
}
