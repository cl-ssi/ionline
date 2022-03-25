<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleaseObservationToArqPurchaseProcessDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            //
            $table->text('release_observation')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_purchase_process_detail', function (Blueprint $table) {
            //
            $table->dropColumn('release_observation');
        });
    }
}
