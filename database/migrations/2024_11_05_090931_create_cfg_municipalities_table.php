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
        Schema::create('cfg_municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rut');
            $table->string('address');
            $table->string('emails');
            $table->foreignId('commune_id')->constrained('cl_communes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfg_municipalities');
    }
};
