<?php

namespace App\Observers;

use App\Models\Pharmacies\FractionationItem;
use App\Models\Pharmacies\Batch;

class FractionationItemObserver
{
    /**
     * Handle the FractionationItem "created" event.
     *
     * @param  \App\Models\FractionationItem  $fractionationItem
     * @return void
     */
    public function created(FractionationItem $fractionationItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $fractionationItem->product_id,
          'due_date' =>  $fractionationItem->due_date,
          'batch'    =>  $fractionationItem->batch, ],
        [ 'product_id' => $fractionationItem->product_id,
          'due_date' =>  $fractionationItem->due_date,
          'batch'    =>  $fractionationItem->batch,
      ])->decrement('count',$fractionationItem->amount);
      $batch = Batch::where('due_date',$fractionationItem->due_date)
                    ->where('batch',$fractionationItem->batch)->first();
      $fractionationItem->batch_id = $batch->id;
      $fractionationItem->save();
    }

    /**
     * Handle the FractionationItem "updated" event.
     *
     * @param  \App\Models\FractionationItem  $fractionationItem
     * @return void
     */
    public function updated(FractionationItem $fractionationItem)
    {
        //
    }

    /**
     * Handle the FractionationItem "deleted" event.
     *
     * @param  \App\Models\FractionationItem  $fractionationItem
     * @return void
     */
    public function deleted(FractionationItem $fractionationItem)
    {
      $batch = Batch::updateOrCreate(
        [ 'product_id' => $fractionationItem->product_id,
          'due_date' =>  $fractionationItem->due_date,
          'batch'    =>  $fractionationItem->batch, ],
        [ 'product_id' => $fractionationItem->product_id,
          'due_date' =>  $fractionationItem->due_date,
          'batch'    =>  $fractionationItem->batch,
      ])->increment('count',$fractionationItem->amount);
      $batch = Batch::where('due_date',$fractionationItem->due_date)
                    ->where('batch',$fractionationItem->batch)->first();
      $fractionationItem->batch_id = $batch->id;
      $fractionationItem->save();
    }

    /**
     * Handle the FractionationItem "restored" event.
     *
     * @param  \App\Models\FractionationItem  $fractionationItem
     * @return void
     */
    public function restored(FractionationItem $fractionationItem)
    {
        //
    }

    /**
     * Handle the FractionationItem "force deleted" event.
     *
     * @param  \App\Models\FractionationItem  $fractionationItem
     * @return void
     */
    public function forceDeleted(FractionationItem $fractionationItem)
    {
        //
    }
}
