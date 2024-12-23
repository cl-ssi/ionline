<?php

use App\Models\Inv\Inventory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //TODO: Esto es posible que ya no sea necesario
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            if ($inventory->product) {
                $inventory->update([
                    'unspsc_product_id' => $inventory->product->unspsc_product_id,
                ]);
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
