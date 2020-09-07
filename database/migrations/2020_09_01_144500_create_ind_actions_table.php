<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->text('name');
            $table->text('verification_means');
            $table->enum('target_type',['de mantención','de disminución de la brecha'])->nullable();
            $table->string('numerator')->nullable();
            $table->string('numerator_source')->nullable();
            $table->string('denominator')->nullable();
            $table->string('denominator_source')->nullable();
            $table->decimal('weighting', 6, 3)->nullable(); // Ponderación al corte de la acción
            $table->timestamps();
            $table->bigInteger('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('ind_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ind_actions');
    }
}
