<?php

namespace App\Livewire\Unspsc;

use App\Services\UnspscService;
use Livewire\Attributes\On; 
use Livewire\Component;

class ProductSearch extends Component
{
    public $search;
    public $results;
    public $product_id;
    public $showCode = false;
    public $smallInput = false;

    public function mount()
    {
        $this->results = collect([]);
    }

    public function render()
    {
        return view('livewire.unspsc.product-search');
    }

    #[On('onClearSearch')] 
    public function onClearSearch()
    {
        $this->results = collect([]);
    }

    #[On('productId')] 
    public function productId($value)
    {
        $this->product_id = $value;
    }

    #[On('searchProduct')] 
    public function searchProduct($value)
    {
        $this->search = $value;

        $results = collect([]);

        if($this->search != '')
            $results = (new UnspscService(90))->search($this->search);

        $this->results = $results;
    }

    #[On('updatedProductId')] 
    public function updatedProductId($value)
    {
        $this->dispatch('myProductId', $value);
    }
}
