<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\ReceivingItem;

class AddReceivingItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:receivingItem';

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
      $receivingItems = ReceivingItem::all();
      foreach ($receivingItems as $key => $receivingItem) {
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
      // print_r("### ReceivingItem finalizado.");
      $this->info('### ReceivingItem finalizado.');
    }
}
