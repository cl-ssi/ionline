<?php

namespace App\Http\Livewire\Unspsc;

use App\Services\UnspscService;
use Livewire\Component;

class ProductSearch extends Component
{
    public $search;
    public $results;
    public $product_id;
    public $showCode = false;
    public $smallInput = false;

    protected $listeners = [
        'searchProduct',
        'productId',
        'onClearSearch',
    ];

    public function mount()
    {
        $this->results = collect([]);
    }

    public function render()
    {
        return view('livewire.unspsc.product-search');
    }

    public function onClearSearch()
    {
        $this->results = collect([]);
    }

    public function productId($value)
    {
        $this->product_id = $value;
    }

    public function searchProduct($value)
    {
        $this->search = $value;

        $results = collect([]);

        if($this->search != '')
            $results = (new UnspscService(90))->search($this->search);

        $this->results = $results;
    }

    public function updatedProductId($value)
    {
        $this->emit('myProductId', $value);
    }
}
