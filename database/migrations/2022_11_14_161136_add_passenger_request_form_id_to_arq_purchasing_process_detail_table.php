<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassengerRequestFormIdToArqPurchasingProcessDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('item_request_form_id')->nullable()->change();
            $table->dropForeign(['item_request_form_id']);
            $table->foreign('item_request_form_id')->references('id')->on('arq_item_request_forms');

            $table->foreignId('passenger_request_form_id')->nullable()->after('item_request_form_id')->constrained('arq_passengers');
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
            $table->dropForeign(['passenger_request_form_id']);
            $table->dropColumn('passenger_request_form_id');
        });
    }
}
