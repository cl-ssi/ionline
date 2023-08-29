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
        Schema::create('well_absences', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->nullable();
            $table->string('dv')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ley')->nullable();
            $table->string('nombre_unidad')->nullable();
            $table->tinyInteger('mes_ausentismo')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->date('fecha_termino_2')->nullable();
            $table->float('ausentismo_calculado')->nullable();
            $table->float('total_dias_ausentismo')->nullable();
            $table->float('ausentismos_en_periodo')->nullable();
            $table->string('tipo_ausentismo')->nullable();
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
        Schema::dropIfExists('well_absences');
    }
};
