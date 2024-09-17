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
        Schema::create('sgr_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained('sgr_requirements');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('event_id')->nullable()->constrained('sgr_events');
            $table->boolean('in_copy');
            $table->boolean('following');
            $table->integer('events_pending_view');
            $table->boolean('archived');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgr_participants');
    }
};
