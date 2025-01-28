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
        Schema::create('dnc_available_places', function (Blueprint $table) {
            $table->id();

            $table->foreignId('estament_id')->nullable()->constrained('cfg_estaments');
            $table->string('family_position')->nullable();
            $table->integer('places_number')->nullable();
            $table->foreignId('identify_need_id')->nullable()->constrained('dnc_identify_needs');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnc_available_places');
    }
};
