<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ind_sections', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('number');
            $table->decimal('weighting', 6, 3)->nullable(); // % de la evaluación anual
            $table->foreignId('indicator_id')->constrained('indicators');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ind_sections');
    }
};
