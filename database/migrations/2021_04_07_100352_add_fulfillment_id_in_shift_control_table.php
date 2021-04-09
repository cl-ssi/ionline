<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFulfillmentIdInShiftControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_shift_controls', function (Blueprint $table) {
          $table->unsignedBigInteger('fulfillment_id')->after('service_request_id')->nullable();
          $table->foreign('fulfillment_id')->references('id')->on('doc_fulfillments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_shift_controls', function (Blueprint $table) {
              $table->dropColumn('fulfillment_id');
        });
    }
}
