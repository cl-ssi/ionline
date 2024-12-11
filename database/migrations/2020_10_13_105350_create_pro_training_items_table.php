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
        Schema::create('pro_training_items', function (Blueprint $table) {
            $table->id();
            $table->string('linieamiento_estrategico')->nullable();
            $table->string('temas')->nullable();
            $table->text('objetivos_educativos')->nullable();
            $table->integer('med_odont_qf')->nullable();
            $table->integer('otros_profesionales')->nullable();
            $table->integer('tec_nivel_superior')->nullable();
            $table->integer('tec_salud')->nullable();
            $table->integer('administrativo_salud')->nullable();
            $table->integer('auxiliares_salud')->nullable();
            $table->integer('total')->nullable();
            $table->string('num_hr_pedagodicas')->nullable();
            $table->string('item_cap')->nullable();
            $table->enum('fondo_muni', ['SI', 'NO'])->nullable()->default('SI');
            $table->string('otro_fondo')->nullable();
            $table->string('total_presupuesto_est')->nullable();
            $table->string('org_ejecutor')->nullable();
            $table->string('coordinador')->nullable();
            $table->string('fecha_ejecucion')->nullable();
            $table->foreignId('programming_id')->constrained('pro_programmings');
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
        Schema::dropIfExists('pro_training_items');
    }
};
