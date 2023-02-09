<?php

namespace App\Observers;

use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\Batch;

class ReceivingItemObserver
{
    /**
     * Handle the ReceivingItem "created" event.
     *
     * @param  \App\Models\ReceivingItem  $receivingItem
     * @return void
     */
    public function created(ReceivingItem $receivingItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $receivingItem->product_id,
          'due_date' =>  $receivingItem->due_date,
          'batch'    =>  $receivingItem->batch, ],
        [ 'product_id' => $receivingItem->product_id,
          'due_date' =>  $receivingItem->due_date,
          'batch'    =>  $receivingItem->batch,
      ])->increment('count',$receivingItem->amount);
      $batch = Batch::where('due_date',$receivingItem->due_date)
                    ->where('batch',$receivingItem->batch)->first();
      $receivingItem->batch_id = $batch->id;
      $receivingItem->save();
    }

    /**
     * Handle the ReceivingItem "updated" event.
     *
     * @param  \App\Models\ReceivingItem  $receivingItem
     * @return void
     */
    public function updated(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Handle the ReceivingItem "deleted" event.
     *
     * @param  \App\Models\ReceivingItem  $receivingItem
     * @return void
     */
    public function deleted(ReceivingItem $receivingItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $receivingItem->product_id,
          'due_date' =>  $receivingItem->due_date,
          'batch'    =>  $receivingItem->batch, ],
        [ 'product_id' => $receivingItem->product_id,
          'due_date' =>  $receivingItem->due_date,
          'batch'    =>  $receivingItem->batch,
      ])->decrement('count',$receivingItem->amount);
      $batch = Batch::where('due_date',$receivingItem->due_date)
                    ->where('batch',$receivingItem->batch)->first();
      $receivingItem->batch_id = $batch->id;
      $receivingItem->save();
    }

    /**
     * Handle the ReceivingItem "restored" event.
     *
     * @param  \App\Models\ReceivingItem  $receivingItem
     * @return void
     */
    public function restored(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Handle the ReceivingItem "force deleted" event.
     *
     * @param  \App\Models\ReceivingItem  $receivingItem
     * @return void
     */
    public function forceDeleted(ReceivingItem $receivingItem)
    {
        //
    }
}
