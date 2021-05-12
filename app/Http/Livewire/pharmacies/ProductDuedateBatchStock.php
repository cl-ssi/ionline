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

    public function foo(){
      $product = Product::where('barcode',$this->barcode)->first();
      $this->product_id = $product->id;
    }

    public function render()
    {
        // dd($this->barcode);
        $product = Product::find($this->product_id);
        // foreach ($products as $key1 => $product) {
        $this->array = [];
        if ($product) {

          $this->barcode = $product->barcode;
          $this->unity = $product->unit;
          $this->count = "";

          foreach ($product->purchaseItems as $key1 => $purchaseItem) {
            $this->array[$purchaseItem->due_date->format('d-m-Y') . " - " . $purchaseItem->batch] = 0;
          }
          foreach ($product->receivingItems as $key2 => $receivingItems) {
            $this->array[$receivingItems->due_date->format('d-m-Y') . " - " . $receivingItems->batch] = 0;
          }
          foreach ($product->dispatchItems as $key3 => $dispatchItems) {
            $this->array[$dispatchItems->due_date->format('d-m-Y') . " - " . $dispatchItems->batch] = 0;
          }

          foreach ($product->purchaseItems as $key1 => $purchaseItem) {
            $this->array[$purchaseItem->due_date->format('d-m-Y') . " - " . $purchaseItem->batch] += $purchaseItem->amount;
          }
          foreach ($product->receivingItems as $key2 => $receivingItems) {
            $this->array[$receivingItems->due_date->format('d-m-Y') . " - " . $receivingItems->batch] += $receivingItems->amount;
          }
          foreach ($product->dispatchItems as $key3 => $dispatchItems) {
            $this->array[$dispatchItems->due_date->format('d-m-Y') . " - " . $dispatchItems->batch] -= $dispatchItems->amount;
          }

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


          // //primera vez
          // if ($this->due_date_batch == null) {
          //   $this->count = $this->array[array_key_first($this->array)];
          // }

        }

        return view('livewire.pharmacies.product-duedate-batch-stock');
    }
}
