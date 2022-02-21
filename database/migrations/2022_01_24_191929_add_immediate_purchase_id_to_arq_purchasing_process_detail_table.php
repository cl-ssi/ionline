<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImmediatePurchaseIdToArqPurchasingProcessDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->foreignId('immediate_purchase_id')->after('tender_id')->nullable()->constrained('arq_immediate_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->dropForeign(['immediate_purchase_id']);
            $table->dropColumn('immediate_purchase_id');
        });
    }
}
