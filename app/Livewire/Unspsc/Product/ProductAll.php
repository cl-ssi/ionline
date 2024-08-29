<?php

namespace App\Livewire\Unspsc\Product;

use App\Services\UnspscService;
use Livewire\Component;
use Livewire\WithPagination;

class ProductAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $products;

    public function mount()
    {
        $this->products = collect([]);
    }

    public function render()
    {
        return view('livewire.unspsc.product.product-all');
    }

    public function updatedSearch()
    {
        $products = collect([]);

        if($this->search != '')
        {
            $products = (new UnspscService(200))->search($this->search);
        }

        $this->products = $products;
    }
}
