<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Parameters\Program;
use App\Models\Unspsc\Product as UnspscProduct;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\TypeReception;
use Livewire\Component;

class ControlReviewProduct extends Component
{
    public $store;
    public $control;
    public $search_product;
    public $indexEdit;
    public $item_id;
    public $wre_product_id;
    public $unspsc_product_id;
    public $unspsc_product_name;
    public $description;
    public $barcode;
    public $quantity;
    public $quantity_received;
    public $quantity_return;
    public $generate_return;
    public $return_note;
    public $switch_status;
    public $items;

    protected $listeners = [
        'myProductId'
    ];

    public function render()
    {
        return view('livewire.warehouse.control.control-review-product');
    }

    public function rules()
    {
        return [
            'description'       => 'required|string|min:2|max:255',
            'unspsc_product_id' => 'required|integer|exists:unspsc_products,id',
            'quantity_received' => 'required|integer|min:0|max:' . $this->quantity
        ];
    }

    public function getRulesFinish()
    {
        return [
            'return_note' => 'nullable|required_if:generate_return,1',
        ];
    }

    public function mount()
    {
        $this->items = $this->getItems();
        $this->productId = null;
        $this->generate_return = false;
        $this->switch_status = 1;
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
            $item['description'] = $controlItem->product->name;
            $item['program_name'] = $controlItem->program_name;
            $item['program_id'] = $controlItem->program_id;
            $item['barcode'] = $controlItem->product->barcode;
            $item['status'] = $this->getStatus($item['quantity'], $item['quantity_received']);

            $arrayItems[] = $item;
        }
        return $arrayItems;
    }

    public function editProduct($index)
    {
        $this->indexEdit = $index;
        $this->item_id = $this->items[$index]['item_id'];
        $this->wre_product_id = $this->items[$index]['wre_product_id'];
        $this->unspsc_product_id = $this->items[$index]['unspsc_product_id'];
        $this->unspsc_product_name = $this->items[$index]['unspsc_product_name'];
        $this->description = $this->items[$index]['description'];
        $this->barcode = $this->items[$index]['barcode'];
        $this->quantity = $this->items[$index]['quantity'];
        $this->quantity_received = $this->items[$index]['quantity_received'];

        $this->emit('searchProduct',  $this->items[$index]['unspsc_product_name']);
        $this->emit('productId', $this->items[$index]['unspsc_product_id']);
    }

    public function updateProduct()
    {
        $dataValidated = $this->validate();

        $product = UnspscProduct::find($dataValidated['unspsc_product_id']);
        $quantity = $this->items[$this->indexEdit]['quantity'];
        $quantity_received = $dataValidated['quantity_received'];
        $status = $this->getStatus($quantity, $quantity_received);

        $this->items[$this->indexEdit]['unspsc_product_id'] = $product->id;
        $this->items[$this->indexEdit]['unspsc_product_name'] = $product->name;
        $this->items[$this->indexEdit]['description'] = $dataValidated['description'];
        $this->items[$this->indexEdit]['quantity_received'] = $dataValidated['quantity_received'];
        $this->items[$this->indexEdit]['quantity_return'] = $quantity - $dataValidated['quantity_received'];
        $this->items[$this->indexEdit]['status'] = $status;

        $this->generate_return = $this->getRecepcionStatus($status);

        $this->control->refresh();
        $this->resetInput();
    }

    public function updatedSearchProduct()
    {
        $this->emit('searchProduct', $this->search_product);
    }

    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }

    public function resetInput()
    {
        $this->indexEdit = null;
        $this->item_id = null;
        $this->description = null;
        $this->wre_product_id = null;
        $this->unspsc_product_id = null;
        $this->unspsc_product_name = null;
        $this->barcode = null;
        $this->quantity = null;
        $this->quantity_received = null;

        $this->emit('onClearSearch');
        $this->emit('productId', null);
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
                'program_id' =>  $this->control->program_id,
                'type_reception_id' => TypeReception::return(),
                'store_id' => $this->control->store_origin_id,
                'store_origin_id' => $this->store->id,
            ]);
        }

        foreach($this->items as $item)
        {
            $program = $item['program_id'] ? Program::find($item['program_id']) : null;
            $localProduct = Product::find($item['wre_product_id']);

            $foreignProduct = Product::query()
                ->whereStoreId($this->control->store_origin_id)
                ->whereBarcode($localProduct->barcode)
                ->first();

            $localProduct->update([
                'name' => $item['description'],
                'unspsc_product_id' => $item['unspsc_product_id'],
            ]);

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
            'type' => 'receiving'
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
}
