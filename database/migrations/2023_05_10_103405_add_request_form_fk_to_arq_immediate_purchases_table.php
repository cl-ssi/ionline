<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestFormFkToArqImmediatePurchasesTable extends Migration
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
            $table->foreignId('request_form_id')->after('direct_deal_id')->nullable()->constrained('arq_request_forms');
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
            $table->dropForeign(['request_form_id']);
            $table->dropColumn('request_form_id');
        });
    }
}
