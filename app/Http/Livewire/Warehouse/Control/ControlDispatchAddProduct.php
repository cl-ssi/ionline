<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Pharmacies\Program;
use Livewire\Component;

class ControlDispatchAddProduct extends Component
{
    public $store;
    public $control;
    public $programs;
    public $controlItems;
    public $control_item_id;
    public $program_id;
    public $barcode;
    public $quantity = 0;
    public $max = 0;

    public function rules()
    {
        return [
            'program_id'        => 'required|exists:frm_programs,id',
            'control_item_id'   => 'required|exists:wre_control_items,id',
            'quantity'          => 'required|integer|min:1|max:' . $this->max,
        ];
    }

    public function mount()
    {
        $this->controlItems = collect([]);
        $this->programs = $this->getPrograms();
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-dispatch-add-product');
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

    public function getProducts()
    {
        $controlItems = collect([]);

        if($this->program_id)
        {
            $controlItems = ControlItem::query()
                ->whereHas('control', function($query) {
                    $query->whereStoreId($this->store->id);
                })
                ->whereProgramId($this->program_id)
                ->groupby('program_id', 'product_id');

            // ignore products do not have stock
            $productWithStock = clone $controlItems;
            $idIgnores = $productWithStock->whereBalance(0)
                ->pluck('product_id');

            $controlItems = $controlItems->whereNotIn('product_id', $idIgnores)
                ->get();
        }

        return $controlItems;
    }

    public function updatedControlItemId()
    {
        $controlItem = ControlItem::find($this->control_item_id);
        $this->barcode = ($controlItem) ? $controlItem->product->barcode : '';
        $this->max = 0;
        $this->quantity = 0;
        if($this->control_item_id)
            $this->max = lastBalance($controlItem->product, $controlItem->program);
    }

    public function updatedProgramId()
    {
        $this->barcode = '';
        $this->quantity = 0;
        $this->max = 0;

        $this->controlItems = $this->getProducts();
    }

    public function addProduct()
    {
        $dataValidated = $this->validate();
        $controlItem = ControlItem::find($this->control_item_id);
        $lastBalance = lastBalance($controlItem->product, $controlItem->program);
        $dataValidated['balance'] = $lastBalance - $dataValidated['quantity'];
        $dataValidated['product_id'] = $controlItem->product_id;
        $dataValidated['control_id'] = $this->control->id;
        $dataValidated['barcode'] = $controlItem->barcode;

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
        {
            $controlItem = ControlItem::create($dataValidated);
        }

        $this->emit('refreshControlProductList');
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->control_item_id = null;
        $this->program_id = null;
        $this->controlItems = collect([]);
        $this->max = 0;
        $this->quantity = 0;
        $this->barcode = '';
    }
}
