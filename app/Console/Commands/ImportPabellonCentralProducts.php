<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Pharmacies\Product;
use App\Models\Pharmacies\Receiving;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\Batch;

class ImportPabellonCentralProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ImportPabellonCentralProducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa productos y sus ingresos en modulo de farmacia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $receiving = new Receiving();$receiving->date = now();$receiving->establishment_id = 7;$receiving->pharmacy_id = 8;$receiving->notes = "CARGA INICIAL";$receiving->user_id = 15925608;$receiving->save();

            // $product = new Product();$product->barcode = '2420251';$product->name = 'ACEITE MINERAL PARA MYCOPLASMA IST2.';$product->unit = 'UD';$product->stock = 0;$product->pharmacy_id = 8;$product->category_id = 7;$product->program_id = 88;$product->save();
            // $batch = new Batch();$batch->product_id = $product->id;$batch->due_date = '2100-01-01';$batch->batch = 'S/Lote';$batch->count = 0;$batch->save();
            // $receivingItem = new ReceivingItem();$receivingItem->barcode = $product->barcode;$receivingItem->receiving_id = $receiving->id;$receivingItem->product_id = $product->id;$receivingItem->amount = 0;$receivingItem->unity = $product->unit;$receivingItem->due_date = '2100-01-01';$receivingItem->batch = 'S/Lote';$receivingItem->batch_id = $batch->id;$receivingItem->save();

        } catch (Exception $e) {
            print('Excepción capturada: '.  $e->getMessage(). "\n");
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
