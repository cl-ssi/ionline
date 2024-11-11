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
        Schema::create('agr_cdps', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('program_id')->constrained('cfg_programs');
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('document_id')->nullable()->constrained('documents');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agr_cdps');
    }
};
