<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pharmacies\Product;

class UpdateStorageConditions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-storage-conditions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update storage conditions for products with pharmacy_id 1';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Encuentra todos los productos con pharmacy_id == 1
        $products = Product::where('pharmacy_id', 1)->get();

        foreach ($products as $product) {
            // Agrega el salto de línea y el texto
            $product->storage_conditions .= "\nLiberado para distribución";
            $product->save();
        }

        $this->info('Storage conditions updated for products with pharmacy_id 1.');

        return 0;
    }
}