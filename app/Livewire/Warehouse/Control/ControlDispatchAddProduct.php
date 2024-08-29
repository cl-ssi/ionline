<?php

namespace App\Livewire\Warehouse\Control;

use App\Models\Parameters\Program;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use Livewire\Component;

class ControlDispatchAddProduct extends Component
{
    public $store;
    public $control;
    public $control_item_id;
    public $barcode;
    public $search_store_product;
    public $controlItems;
    public $quantity = 0;
    public $max = 0;

    public function rules()
    {
        return [
            'control_item_id'   => 'required|exists:wre_control_items,id',
            'quantity'          => 'required|integer|min:1|max:' . $this->max,
        ];
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-dispatch-add-product');
    }

    public function mount()
    {
        $this->controlItems = collect([]);
    }

    public function getPrograms()
    {
        $idsPrograms = Control::query()
            ->where('wre_controls.store_id', $this->control->store_id)
            ->select([
                'wre_control_items.program_id',
            ])
            ->join('wre_control_items', 'wre_controls.id', '=', 'wre_control_items.control_id')
            ->groupBy('wre_control_items.program_id')
            ->pluck('wre_control_items.program_id');

        $programs = Program::findMany($idsPrograms);

        return $programs;
    }

    public function updatedSearchStoreProduct($searchValue)
    {
        $this->resetInput();
        $controlItems = collect([]);
        $search = "%$searchValue%";

        if($searchValue)
        {
            $productsOutStock = Product::outStock($this->store, $this->control->program);

            $controlItems = ControlItem::query()
                ->when($searchValue, function($query) use($search) {
                    $query->whereHas('product', function($subquery) use($search) {
                        $subquery->where('name', 'like', $search)
                            ->orWhere('barcode', 'like', $search)
                            ->orWhereHas('product', function ($q) use($search) {
                                $q->where('name', 'like', $search);
                            });
                    });
                })
                ->whereHas('control', function($query) {
                    $query->whereStoreId($this->store->id);
                })
                ->whereProgramId($this->control->program_id)
                ->groupBy('program_id', 'product_id')
                ->whereNotIn('product_id', $productsOutStock)
                ->get();
        }

        $this->controlItems = $controlItems;
    }

    public function updatedControlItemId()
    {
        $controlItem = ControlItem::find($this->control_item_id);
        $this->barcode = ($controlItem) ? $controlItem->product->barcode : '';
        $this->max = 0;
        $this->quantity = 0;
        if($this->control_item_id)
            $this->max = Product::lastBalance($controlItem->product, $controlItem->program);
    }

    public function addProduct()
    {
        $dataValidated = $this->validate();

        $controlItem = ControlItem::find($this->control_item_id);
        $lastBalance = Product::lastBalance($controlItem->product, $controlItem->program);
        $dataValidated['balance'] = $lastBalance - $dataValidated['quantity'];
        $dataValidated['control_id'] = $this->control->id;
        $dataValidated['program_id'] = $this->control->program_id;
        $dataValidated['product_id'] = $controlItem->product_id;
        $dataValidated['confirm'] = true;

        $controlItem = ControlItem::query()
            ->whereControlId($this->control->id)
            ->whereProgramId($controlItem->program_id)
            ->whereProductId($controlItem->product_id);

        if($controlItem->exists())
        {
            $controlItem = clone $controlItem->first();
            $controlItem->update([
                'quantity'  => $controlItem->quantity + $dataValidated['quantity'],
                'balance'   => $lastBalance - $dataValidated['quantity'],
            ]);
        }
        else
            $controlItem = ControlItem::create($dataValidated);

        $this->search_store_product = '';
        $this->controlItems = collect([]);
        $this->render();
        $this->resetInput();
        $this->dispatch('refreshControlProductList');
    }

    public function resetInput()
    {
        $this->control_item_id = '';
        $this->barcode = '';
        $this->max = 0;
        $this->quantity = 0;
    }
}
