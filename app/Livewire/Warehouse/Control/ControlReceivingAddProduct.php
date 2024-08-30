<?php

namespace App\Livewire\Warehouse\Control;

use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class ControlReceivingAddProduct extends Component
{
    public $store;
    public $control;
    public $type;
    public $unspsc_product_id;
    public $search_unspsc_product;
    public $description;
    public $wre_product_id;
    public $category_id;
    public $quantity;
    public $barcode;
    public $product_barcode;
    public $search_store_product;
    public $store_products;
    public $categories;

    public function rules()
    {
        return [
            'unspsc_product_id' => 'nullable|required_if:type,1|exists:unspsc_products,id',
            'description'       => 'nullable|required_if:type,1|string|min:1|max:255',
            'barcode'           => [
                'nullable',
                'string',
                'min:1',
                'max:255',
                Rule::unique('wre_products', 'barcode')->where('store_id', $this->store->id)
            ],
            'wre_product_id'    => 'nullable|required_if:type,0|exists:wre_products,id',
            'category_id'       => 'nullable|exists:wre_categories,id',
            'quantity'          => 'required|integer|min:1',
        ];
    }

    public function mount()
    {
        $this->type = 1;
        $this->store_products = collect([]);
        $this->categories = $this->store->categories->sortBy('name');
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
                'unspsc_product_id' => $dataValidated['unspsc_product_id'],
                'category_id' => $dataValidated['category_id'] ? $dataValidated['category_id'] : null,
            ]);
        }
        else
        {
            $product = Product::find($dataValidated['wre_product_id']);
        }

        $lastBalance = Product::lastBalance($product, $this->control->program);

        $balance = $dataValidated['quantity'] + $lastBalance;

        $dataValidated['balance'] = $balance;
        $dataValidated['control_id'] = $this->control->id;
        $dataValidated['program_id'] = $this->control->program_id;
        $dataValidated['product_id'] = $product->id;
        $dataValidated['confirm'] = true;

        $controlItem = ControlItem::query()
            ->whereControlId($this->control->id)
            ->whereProgramId($this->control->program_id)
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

        $this->dispatch('refreshControlProductList');
        $this->dispatch('productId', null);
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->type = 1;
        $this->search_unspsc_product = null;
        $this->unspsc_product_id = null;
        $this->wre_product_id = null;
        $this->quantity = null;
        $this->barcode = null;
        $this->description = null;
        $this->dispatch('onClearSearch');
    }

    public function updatedSearchStoreProduct($searchValue)
    {
        $search = "%$searchValue%";
        $products = collect([]);

        if($searchValue != '')
        {
            $products = Product::query()
                ->where('barcode', 'like', $search)
                ->orWhere('name', 'like', $search)
                ->orWhereHas('product', function($query) use($search) {
                    $query->where('name', 'like', $search);
                })
                ->whereStoreId($this->store->id)
                ->get();
        }
        $this->store_products = $products;
        $this->wre_product_id = null;
        $this->product_barcode = null;
    }

    public function updatedSearchUnspscProduct()
    {
        $this->dispatch('searchProduct', $this->search_unspsc_product);
    }

    public function updatedWreProductId()
    {
        $this->product_barcode = '';
        if($this->type == 0 && $this->wre_product_id)
        {
            $product = Product::find($this->wre_product_id);
            $this->product_barcode = $product->barcode;
        }
    }

    public function updatedType()
    {
        $this->store_products = collect([]);
        $this->product_barcode = null;
        $this->search_store_product = null;
        $this->search_unspsc_product = null;
    }

    #[On('myProductId')]
    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }
}
