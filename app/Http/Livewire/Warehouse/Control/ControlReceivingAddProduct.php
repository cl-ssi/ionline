<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use App\Pharmacies\Program;
use Livewire\Component;

class ControlReceivingAddProduct extends Component
{
    public $store;
    public $control;
    public $programs;
    public $type;
    public $unspsc_product_id;
    public $description;
    public $wre_product_id;
    public $program_id;
    public $quantity;
    public $barcode;
    public $search_product;

    protected $listeners = [
        'myProductId'
    ];

    public function rules()
    {
        return [
            'wre_product_id'    => 'nullable|required_if:type,0|exists:wre_products,id',
            'unspsc_product_id' => 'nullable|required_if:type,1|exists:unspsc_products,id',
            'description'       => 'nullable|required_if:type,1|string|min:1|max:255',
            'program_id'        => 'required|exists:frm_programs,id',
            'quantity'          => 'required|integer|min:1',
            'barcode'           => 'required|string|min:1|max:255',
        ];
    }

    public function mount()
    {
        $this->type = 1;
        $this->programs = Program::all();
        $this->products = collect([]);
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-receiving-add-product');
    }

    public function addProduct()
    {
        $dataValidated = $this->validate();

        if($this->type)
        {
            $product = Product::create([
                'name' => $dataValidated['description'],
                'barcode' => $dataValidated['barcode'],
                'store_id' => $this->store->id,
                'unspsc_product_id' => $dataValidated['unspsc_product_id']
            ]);
        }
        else
        {
            $product = Product::find($dataValidated['wre_product_id']);
        }

        $program = Program::find($dataValidated['program_id']);
        $lastBalance = lastBalance($product, $program);

        $balance = $dataValidated['quantity'] + $lastBalance;

        $dataValidated['balance'] = $balance;
        $dataValidated['control_id'] = $this->control->id;
        $dataValidated['product_id'] = $product->id;

        $controlItem = ControlItem::query()
            ->whereControlId($this->control->id)
            ->whereProgramId($dataValidated['program_id'])
            ->whereProductId($product->id);

        if($controlItem->exists())
        {
            $controlItem = clone $controlItem->first();
            $controlItem->update([
                'quantity'  => $controlItem->quantity + $dataValidated['quantity'],
                'balance'   => $controlItem->quantity + $dataValidated['quantity'],
            ]);
        }
        else
        {
            ControlItem::create($dataValidated);
        }

        $this->emit('refreshControlProductList');
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->type = 1;
        $this->search_product = null;
        $this->unspsc_product_id = null;
        $this->wre_product_id = null;
        $this->program_id = null;
        $this->quantity = null;
        $this->barcode = null;
        $this->description = null;
        $this->emit('onClearSearch');
    }

    public function updatedSearchProduct()
    {
        $this->emit('searchProduct', $this->search_product);
    }

    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }

    public function updatedWreProductId()
    {
        $this->barcode = '';
        if($this->type == 0 && $this->wre_product_id)
        {
            $product = Product::find($this->wre_product_id);
            $this->barcode = $product->barcode;
        }
    }

    public function updatedType()
    {
        if($this->type)
        {
            $this->barcode = '';
        }
    }
}
