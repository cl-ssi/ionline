<?php

namespace App\Livewire\Unspsc\Product;

use Livewire\Component;

class ProductEdit extends Component
{
    public $segment;
    public $family;
    public $class;
    public $product;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->product->name;
    }

    public function render()
    {
        return view('livewire.unspsc.product.product-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->product->update($dataValidated);
        $this->product->refresh();
        return redirect()->route('products.index', ['segment' => $this->segment, 'family' => $this->family, 'class' => $this->class]);
    }

    public function changeExperiesAt()
    {
        $this->product->update([
            'experies_at' => ($this->product->experies_at == null) ? now() : null
        ]);
        $this->product->refresh();
        $this->render();
    }
}
