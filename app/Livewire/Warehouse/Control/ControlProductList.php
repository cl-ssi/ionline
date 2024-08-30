<?php

namespace App\Livewire\Warehouse\Control;

use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Models\Warehouse\TypeReception;
use Livewire\Attributes\On;
use Livewire\Component;

class ControlProductList extends Component
{
    public $store;
    public $control;
    public $controlItems;
    public $nav;

    #[On('refreshControlProductList')]
    public function mount()
    {
        $this->controlItems = $this->control->items->sortByDesc('created_at');
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-product-list');
    }

    public function deleteItem(ControlItem $controlItem)
    {
        $currentBalance = Product::lastBalance($controlItem->product, $controlItem->program);
        $amountToRemove = $controlItem->quantity;

        if(($controlItem->control->isReceiving() && ($currentBalance >= $controlItem->balance)) OR $controlItem->control->isDispatch())
        {
            $controlItems = ControlItem::query()
                ->whereProgramId($controlItem->program_id)
                ->whereProductId($controlItem->product_id)
                ->whereConfirm(true)
                ->where('id', '>', $controlItem->id)
                ->get();

            foreach($controlItems as $ci)
            {
                if($controlItem->control->isReceiving())
                    $newBalance = $ci->balance - $amountToRemove;
                else
                    $newBalance = $ci->balance + $amountToRemove;

                $ci->update([
                    'balance' => $newBalance
                ]);
            }

            $controlItem->delete();
        }

        $this->control->refresh();
        $this->mount();
    }

    public function sendToStore()
    {
        $control = $this->control;

        $control->update([
            'confirm' => true,
            'status' => false
        ]);

        if($control->isSendToStore())
        {
            $controlDispatch = Control::create([
                'type_reception_id' => TypeReception::receiveFromStore(),
                'store_origin_id' => $control->store_id,
                'store_id' => $control->store_destination_id,
                'program_id' => $control->program_id,
                'confirm' => false,
                'type' => true,
                'date' => $control->date,
                'status' => true
            ]);

            foreach($control->items as $item)
            {
                if($item->product->barcode != null)
                {
                    $existsProduct = Product::query()
                        ->whereStoreId($controlDispatch->store_id)
                        ->whereBarcode($item->product->barcode);

                    if($existsProduct->exists())
                        $product = clone $existsProduct->first();
                    else
                    {
                        $product = Product::create([
                            'name' => $item->product->name,
                            'barcode' => $item->product->barcode,
                            'unspsc_product_id' => $item->product->unspsc_product_id,
                            'store_id' => $controlDispatch->store_id,
                        ]);
                    }
                    $product_id = $product->id;
                }
                else
                {
                    $product_id = $item->product->id;
                }

                ControlItem::create([
                    'quantity' => $item->quantity,
                    'balance' => 0,
                    'confirm' => false,
                    'control_id' => $controlDispatch->id,
                    'program_id' => $item->program_id,
                    'product_id' => $product_id
                ]);
            }
        }

        session()->flash('success', "Se ha realizado la transferencia a la bodega.");

        return redirect()->route('warehouse.controls.index', [
            'store' => $this->store,
            'control' => $this->control,
            'type' => 'dispatch',
            'nav' => $this->nav,
        ]);
    }

    public function finish()
    {
        $this->control->update([
            'status' => false,
        ]);

        session()->flash('success', 'El ' . $this->control->type_format . ' fue cargado exitosamente.');

        return redirect()->route('warehouse.controls.index', [
            'store' => $this->store,
            'type' => $this->control->isReceiving() ? 'receiving' : 'dispatch',
            'nav' => $this->nav,
        ]);
    }
}
