<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pharmacies\Batch;
use App\Models\Pharmacies\PurchaseItem;

class AddPurchaseItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:purchaseItem';

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
      $purchaseItems = PurchaseItem::all();
      foreach ($purchaseItems as $key => $purchaseItem) {
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
      // print_r("### PurchaseItem finalizado.");
      $this->info('### PurchaseItem finalizado.');
    }
}
