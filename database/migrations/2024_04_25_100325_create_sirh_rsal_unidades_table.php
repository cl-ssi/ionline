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
        Schema::create('sirh_rsal_unidades', function (Blueprint $table) {
            $table->id();
            $table->string('unid_codigo')->nullable(false);
            $table->string('unid_descripcion')->nullable();
            $table->string('unid_codigo_deis')->nullable();
            $table->string('unid_comuna')->nullable();
            $table->string('unid_cod_dipres')->nullable();
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
        Schema::dropIfExists('sirh_rsal_unidades');
    }
};
