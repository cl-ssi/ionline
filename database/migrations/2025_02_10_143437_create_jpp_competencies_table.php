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
        Schema::create('jpp_competencies', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jpp_competencies');
    }
};
