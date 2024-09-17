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
        Schema::create('sgr_requirements', function (Blueprint $table) {
            $table->id();
            $table->text('subject');
            $table->boolean('priority');
            $table->datetime('limit_at')->nullable();
            $table->foreignId('event_type_id')->constrained('sgr_event_types');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parte_id')->nullable()->constrained('partes');
            $table->foreignId('category_id')->nullable()->constrained('sgr_categories');
            $table->integer('group_number')->nullable();
            $table->foreignId('establishment_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgr_requirements');
    }
};
