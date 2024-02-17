<?php

namespace App\Http\Livewire\Pharmacies\Products;

use App\Models\Pharmacies\Product;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filterName = null;

    public function search() {
        if($this->filterName == '') {
            $this->filterName = null;
        }
    }

    public function render()
    {
        $products = Product::where('pharmacy_id',session('pharmacy_id'))
            ->with('category','program')
            // Cuando filtername no sea vacio se filtra por nombre
            ->when($this->filterName, function ($query) {
                $query->where('name', 'LIKE', "%$this->filterName%");
            })
            ->orderBy('name', 'ASC')
            // ->get();
            ->paginate(100);

        return view('livewire.pharmacies.products.index-products', compact('products'));
    }
}
