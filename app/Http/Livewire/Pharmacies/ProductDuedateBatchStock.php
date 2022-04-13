<?php

namespace App\Http\Livewire\Pharmacies;

use Livewire\Component;
use App\Pharmacies\Product;

class ProductDuedateBatchStock extends Component
{
    public $dispatch;
    public $products;
    public $product_id;
    public $array = [];
    public $due_date_batch;
    public $count;
    public $barcode;
    public $unity;

    public function mount()
    {
      	$this->products = Product::where('pharmacy_id',session('pharmacy_id'))
			->where('stock','>',0)
            ->orderBy('name', 'ASC')->get();
    }

    public function foo(){
      $product = Product::where('barcode',$this->barcode)->first();
      $this->product_id = $product->id;
    }

    public function render()
    {
        // dd($this->barcode);
        $product = Product::with(['purchaseItems','receivingItems'])->find($this->product_id);
        // foreach ($products as $key1 => $product) {
        $this->array = [];
        if ($product) {

          $this->barcode = $product->barcode;
          $this->unity = $product->unit;
          $this->count = "";

          // foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          //   $this->array[$purchaseItem->due_date->format('d-m-Y') . " - " . $purchaseItem->batch] = 0;
          // }
          // foreach ($product->receivingItems as $key2 => $receivingItems) {
          //   $this->array[$receivingItems->due_date->format('d-m-Y') . " - " . $receivingItems->batch] = 0;
          // }
          // foreach ($product->dispatchItems as $key3 => $dispatchItems) {
          //   $this->array[$dispatchItems->due_date->format('d-m-Y') . " - " . $dispatchItems->batch] = 0;
          // }
          //
          // foreach ($product->purchaseItems as $key1 => $purchaseItem) {
          //   $this->array[$purchaseItem->due_date->format('d-m-Y') . " - " . $purchaseItem->batch] += $purchaseItem->amount;
          // }
          // foreach ($product->receivingItems as $key2 => $receivingItems) {
          //   $this->array[$receivingItems->due_date->format('d-m-Y') . " - " . $receivingItems->batch] += $receivingItems->amount;
          // }
          // foreach ($product->dispatchItems as $key3 => $dispatchItems) {
          //   $this->array[$dispatchItems->due_date->format('d-m-Y') . " - " . $dispatchItems->batch] -= $dispatchItems->amount;
          // }
          //
          // foreach ($this->array as $key1 => $value) {
          //   //elimina valores en cero
          //   if ($value == 0) {
          //     unset($this->array[$key1]);
          //   }
          //   //seleccion, se obtiene cantidad
          //   if ($key1 == $this->due_date_batch) {
          //     $this->count = $value;
          //   }
          // }

          // se obtienen lotes desde tabla batchs
          foreach ($product->batchs as $key => $batch) {
            $this->array[$batch->due_date->format('d-m-Y') . " - " . $batch->batch] = 0;
          }

          foreach ($product->batchs as $key => $batch) {
            $this->array[$batch->due_date->format('d-m-Y') . " - " . $batch->batch] = $batch->count;
          }

          // seteo de lotes
          foreach ($this->array as $key1 => $value) {
            //elimina valores en cero
            if ($value == 0) {
              unset($this->array[$key1]);
            }
            //seleccion, se obtiene cantidad
            if ($key1 == $this->due_date_batch) {
              $this->count = $value;
            }
          }

        }

        return view('livewire.pharmacies.product-duedate-batch-stock');
    }
}
