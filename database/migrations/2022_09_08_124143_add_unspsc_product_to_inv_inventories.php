<?php

use App\Models\Inv\Inventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnspscProductToInvInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $inventories = Inventory::all();

        foreach($inventories as $inventory)
        {
            if($inventory->product)
            {
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
}
