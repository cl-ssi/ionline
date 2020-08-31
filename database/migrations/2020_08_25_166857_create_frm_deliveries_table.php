<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('establishment_id');
            $table->string('invoice')->nullable();
            $table->date('request_date');
            $table->date('due_date')->nullable();
            $table->string('patient_rut');
            $table->string('patient_name');
            $table->tinyInteger('age');
            $table->string('request_type');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->string('diagnosis');
            $table->string('doctor_name');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });

        Schema::table('frm_deliveries', function ($table){
            $table->foreign('establishment_id')->references('id')->on('frm_establishments');
            $table->foreign('product_id')->references('id')->on('frm_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_deliveries');
    }
}
