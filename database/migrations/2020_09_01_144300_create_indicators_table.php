<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('number');
            $table->text('name');
            $table->decimal('weighting_by_section', 6, 3)->nullable(); //ponderación por corte
            $table->text('numerator');
            $table->text('numerator_source');
            $table->text('denominator')->nullable();
            $table->text('denominator_source')->nullable();
            $table->timestamps();
            $table->bigInteger('comges_id')->unsigned();
            $table->foreign('comges_id')->references('id')->on('ind_comges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicators');
    }
}
