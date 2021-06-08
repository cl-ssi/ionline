<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArqRequestFormsEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
          $table->bigInteger('purchase_unit_id')->unsigned()->nullable();
          $table->bigInteger('purchase_type_id')->unsigned()->nullable();
          $table->foreign('purchase_unit_id')->references('id')->on('cfg_purchase_units');
          $table->foreign('purchase_type_id')->references('id')->on('cfg_purchase_types');
        });
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
