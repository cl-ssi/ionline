<?php

namespace App\Observers;

use App\Models\Pharmacies\PurchaseItem;
use App\Models\Pharmacies\Batch;

class PurchaseItemObserver
{
    /**
     * Handle the PurchaseItem "created" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function created(PurchaseItem $purchaseItem)
    {
        $batch = Batch::updateOrCreate(
          [ 'product_id' => $purchaseItem->product_id,
            'due_date' =>  $purchaseItem->due_date,
            'batch'    =>  $purchaseItem->batch, ],
          [ 'product_id' => $purchaseItem->product_id,
            'due_date' =>  $purchaseItem->due_date,
            'batch'    =>  $purchaseItem->batch,
        ])->increment('count',$purchaseItem->amount);
        $batch = Batch::where('due_date',$purchaseItem->due_date)
                      ->where('batch',$purchaseItem->batch)->first();
        $purchaseItem->batch_id = $batch->id;
        $purchaseItem->save();
    }

    /**
     * Handle the PurchaseItem "updated" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function updated(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Handle the PurchaseItem "deleted" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function deleted(PurchaseItem $purchaseItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $purchaseItem->product_id,
          'due_date' =>  $purchaseItem->due_date,
          'batch'    =>  $purchaseItem->batch, ],
        [ 'product_id' => $purchaseItem->product_id,
          'due_date' =>  $purchaseItem->due_date,
          'batch'    =>  $purchaseItem->batch,
      ])->decrement('count',$purchaseItem->amount);
      $batch = Batch::where('due_date',$purchaseItem->due_date)
                    ->where('batch',$purchaseItem->batch)->first();
      $purchaseItem->batch_id = $batch->id;
      $purchaseItem->save();
    }

    /**
     * Handle the PurchaseItem "restored" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function restored(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Handle the PurchaseItem "force deleted" event.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return void
     */
    public function forceDeleted(PurchaseItem $purchaseItem)
    {
        //
    }
}
