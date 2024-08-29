<?php

namespace App\Livewire\Pharmacies;

use Livewire\Component;
use App\Models\Pharmacies\Product;
use App\Models\Pharmacies\Batch;

class ProductStockAdjustment extends Component
{
    public $products;
    public $product_id = [];
    public $batchs = [];
    public $due_date_batch;
    public $count = 0;

    public function mount(){
        $this->products = Product::where('pharmacy_id',session('pharmacy_id'))
                                ->get();
    }

    public function product_id_change(){
        $product = Product::find($this->product_id);
        $this->batchs = $product->batchs->where('count','<>',0);
    }

    public function due_date_batch_change(){
        $this->count = 0;
        $batch = Batch::find($this->due_date_batch);
        if($batch){
            $this->count = $batch->count;
        }
        
    }

    public function render()
    {
        return view('livewire.pharmacies.product-stock-adjustment');
    }
}
