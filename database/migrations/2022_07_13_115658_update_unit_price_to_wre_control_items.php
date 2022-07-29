<?php

use App\Models\Warehouse\ControlItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUnitPriceToWreControlItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_control_items', function (Blueprint $table) {
            $table->decimal('unit_price', 16, 2)->change();
        });

        // $controlItems = ControlItem::all();

        // foreach($controlItems as $controlItem)
        // {
        //     $unit_price = $controlItem->control->purchaseOrder->items[$controlItem->correlative_po-1]->PrecioNeto;

        //     $controlItem->update([
        //         'unit_price' => $unit_price
        //     ]);
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wre_control_items', function (Blueprint $table) {
            //
        });
    }
}
