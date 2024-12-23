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
        Schema::create('ind_program_aps_glosas', function (Blueprint $table) {
            $table->id();
            $table->integer('periodo');
            $table->integer('numero');
            $table->string('nivel');
            $table->string('prestacion');
            $table->string('poblacion');
            $table->string('verificacion');
            $table->string('profesional');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ind_program_aps_glosas');
    }
};
