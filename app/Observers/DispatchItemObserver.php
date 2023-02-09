<?php

namespace App\Observers;

use App\Models\Pharmacies\DispatchItem;
use App\Models\Pharmacies\Batch;

class DispatchItemObserver
{
    /**
     * Handle the DispatchItem "created" event.
     *
     * @param  \App\Models\DispatchItem  $dispatchItem
     * @return void
     */
    public function created(DispatchItem $dispatchItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $dispatchItem->product_id,
          'due_date' =>  $dispatchItem->due_date,
          'batch'    =>  $dispatchItem->batch, ],
        [ 'product_id' => $dispatchItem->product_id,
          'due_date' =>  $dispatchItem->due_date,
          'batch'    =>  $dispatchItem->batch,
      ])->decrement('count',$dispatchItem->amount);
      $batch = Batch::where('due_date',$dispatchItem->due_date)
                    ->where('batch',$dispatchItem->batch)->first();
      $dispatchItem->batch_id = $batch->id;
      $dispatchItem->save();
    }

    /**
     * Handle the DispatchItem "updated" event.
     *
     * @param  \App\Models\DispatchItem  $dispatchItem
     * @return void
     */
    public function updated(DispatchItem $dispatchItem)
    {
        //
    }

    /**
     * Handle the DispatchItem "deleted" event.
     *
     * @param  \App\Models\DispatchItem  $dispatchItem
     * @return void
     */
    public function deleted(DispatchItem $dispatchItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $dispatchItem->product_id,
          'due_date' =>  $dispatchItem->due_date,
          'batch'    =>  $dispatchItem->batch, ],
        [ 'product_id' => $dispatchItem->product_id,
          'due_date' =>  $dispatchItem->due_date,
          'batch'    =>  $dispatchItem->batch,
      ])->increment('count',$dispatchItem->amount);
      $batch = Batch::where('due_date',$dispatchItem->due_date)
                    ->where('batch',$dispatchItem->batch)->first();
      $dispatchItem->batch_id = $batch->id;
      $dispatchItem->save();
    }

    /**
     * Handle the DispatchItem "restored" event.
     *
     * @param  \App\Models\DispatchItem  $dispatchItem
     * @return void
     */
    public function restored(DispatchItem $dispatchItem)
    {
        //
    }

    /**
     * Handle the DispatchItem "force deleted" event.
     *
     * @param  \App\Models\DispatchItem  $dispatchItem
     * @return void
     */
    public function forceDeleted(DispatchItem $dispatchItem)
    {
        //
    }
}
