<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\PurchaseOrder;
use App\Models\Finance\PurchaseOrder\Prefix;

class PurchaseOrderUpdateCenabast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase_order:update_cenabast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'comanda para actualizar el booleano cenabast de las ordenes de compra';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $purchaseOrders = PurchaseOrder::all();
        foreach ($purchaseOrders as $purchaseOrder) {
            if($purchaseOrder->cenabast == null)
            {
                $cenabast = Prefix::getIsCenabastFromPoCode($purchaseOrder->code); 
                if($cenabast != null)
                {
                    $purchaseOrder->cenabast = $cenabast;
                    $purchaseOrder->save();
                    $this->info('Orden de compra Cenabast actualizado: ' . $purchaseOrder->id);
                }
                
                
            }

        }


        return Command::SUCCESS;
    }
}
