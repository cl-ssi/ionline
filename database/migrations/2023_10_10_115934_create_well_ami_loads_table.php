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
        Schema::create('well_ami_loads', function (Blueprint $table) {
            $table->id();
            $table->integer('id_amipass')->nullable();
            $table->string('centro_de_costo')->nullable();
            $table->string('sucursal')->nullable();
            $table->integer('n_factura')->nullable();
            $table->string('tipo')->nullable();
            $table->datetime('fecha')->nullable();
            $table->bigInteger('n_tarjeta')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->foreignId('run')->nullable()->constrained('users');
            $table->string('dv')->nullable();
            $table->string('tipo_empleado')->nullable();
            $table->integer('monto')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['id_amipass', 'fecha', 'run'], 'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_ami_loads');
    }
};
