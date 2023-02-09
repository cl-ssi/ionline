<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\DispatchItem;

class AddDispatchItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:dispatchItem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $dispatchItems = DispatchItem::all();
      foreach ($dispatchItems as $key => $dispatchItem) {
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
      // print_r("### DispatchItem finalizado.");
      $this->info('### DispatchItem finalizado.');
    }
}
