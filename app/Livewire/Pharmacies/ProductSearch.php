<?php

namespace App\Livewire\Pharmacies;

use Livewire\Component;

use App\Models\Pharmacies\Product;

class ProductSearch extends Component
{
    public $products = [];
    public $product_id;
    public $barcode;
    public $barcode_defer;
    public $experto_id;
    public $product_name;
    public $unity;
    public $defer_active = false;

    public $showSecondDiv = false;

    public $filtro_producto;

    public function mount(){
        $this->products = Product::where('pharmacy_id',session('pharmacy_id'))
                                ->orderBy('name','ASC')->get();

                                $this->dispatch('focus');
    }

    public function toggleSecondDiv()
    {
        $this->showSecondDiv = !$this->showSecondDiv;
    }

    public function updatedBarcode($value)
    {
        $product = Product::where('pharmacy_id',session('pharmacy_id'))->where('barcode',$value)->first();
        if($product){
            $this->product_id = $product->id;
            $product = Product::find($this->product_id);
            $this->unity = $product->unit;
            $this->product_name = $product->name;
            // $this->barcode = $product->barcode;
            $this->experto_id = $product->experto_id;
        }
    }

    public function change(){
        $product = Product::find($this->product_id);
        $this->unity = $product->unit;
        $this->product_name = $product->name;
        $this->barcode_defer = $product->barcode;
        $this->experto_id = $product->experto_id;
        $this->defer_active = true;
    }

    public function updatedFiltroProducto()
    {
        // Filtrar los productos basados en el texto ingresado en $filtro_producto
        $this->products = Product::where('pharmacy_id',session('pharmacy_id'))
                                ->where('name', 'like', '%'.$this->filtro_producto.'%')
                                ->orderBy('name','ASC')
                                ->get();

        $this->render();
    }

    public function render()
    {
        return view('livewire.pharmacies.product-search');
    }
}
