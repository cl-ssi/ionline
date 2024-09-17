<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sgr_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Insertar filas
        DB::table('sgr_event_types')->insert([
            ['name' => 'Creado'],
            ['name' => 'Respondido'],
            ['name' => 'Derivado'],
            ['name' => 'Cerrado'],
            ['name' => 'Reabierto'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgr_event_types');
    }
};
