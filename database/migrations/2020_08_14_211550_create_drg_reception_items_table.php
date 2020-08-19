<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrgReceptionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drg_reception_items', function (Blueprint $table) {
            $table->increments('id');
            // TODO: en MySql se creo la columna como varchar
            $table->text('description');
            $table->unsignedInteger('substance_id');
            $table->string('nue')->nullable();
            $table->integer('sample_number');
            $table->float('document_weight',10,3)->nullable();
            $table->float('gross_weight',10,3);
            $table->float('net_weight',10,3)->nullable();
            $table->float('estimated_net_weight',10,3)->nullable();
            $table->float('sample',8,3);
            $table->float('countersample',8,3);
            $table->float('destruct',10,3);
            $table->string('equivalent')->nullable();
            $table->unsignedInteger('reception_id');
            $table->integer('result_number')->nullable();
            $table->date('result_date')->nullable();
            $table->unsignedInteger('result_substance_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('substance_id')->references('id')->on('drg_substances');
            $table->foreign('reception_id')->references('id')->on('drg_receptions');
            $table->foreign('result_substance_id')->references('id')->on('drg_substances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drg_reception_items');
    }
}
