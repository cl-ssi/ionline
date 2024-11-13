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
        Schema::create('cfg_mayors', function (Blueprint $table) {
            $table->id();
            $table->string('appellative', 100)->nullable();
            $table->string('name')->nullable();
            $table->string('run')->nullable();
            $table->string('decree')->nullable();
            $table->foreignId('municipality_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfg_mayors');
    }
};
