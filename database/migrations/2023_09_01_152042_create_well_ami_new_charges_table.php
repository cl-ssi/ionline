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
        Schema::create('well_ami_new_charges', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->nullable();
            $table->string('dv')->nullable();
            $table->string('nombre')->nullable();
            $table->string('lugar_desempeño')->nullable();
            $table->string('fecha')->nullable();
            $table->integer('dias_habiles_mes')->nullable();
            $table->integer('dias_ausentismo')->nullable();
            $table->integer('valor_dia')->nullable();
            $table->integer('total_regularizado')->nullable();
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
        Schema::dropIfExists('well_ami_new_charges');
    }
};
