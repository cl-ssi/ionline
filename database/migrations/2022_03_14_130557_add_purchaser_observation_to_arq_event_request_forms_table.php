<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaserObservationToArqEventRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_event_request_forms', function (Blueprint $table) {
            //
            $table->text('purchaser_observation')->after('purchaser_amount')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_event_request_forms', function (Blueprint $table) {
            //
        $table->dropColumn('purchaser_observation');

        });
    }
}
