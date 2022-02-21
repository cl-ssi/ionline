<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDirectDealFkToArqImmediatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            //
            $table->foreignId('direct_deal_id')->after('tender_id')->nullable()->constrained('arq_direct_deals');
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
            //
            $table->dropForeign(['direct_deal_id']);
            $table->dropColumn('direct_deal_id');
        });
    }
}
