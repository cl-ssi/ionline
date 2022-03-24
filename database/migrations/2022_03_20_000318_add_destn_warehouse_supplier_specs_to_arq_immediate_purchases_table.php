<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDestnWarehouseSupplierSpecsToArqImmediatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->string('destination_warehouse')->nullable()->after('direct_deal_id');
            $table->text('supplier_specifications')->nullable()->after('destination_warehouse');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->dropColumn(['destination_warehouse', 'supplier_specifications']);
        });
    }
}
