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
        Schema::create('sgr_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained('sgr_requirements');
            $table->text('body');
            $table->foreignId('event_type_id')->constrained('sgr_event_types');
            $table->datetime('limit_at')->nullable();
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('creator_ou_id')->constrained('organizational_units');
            $table->foreignId('sent_to_establishment_id')->nullable()->constrained('establishments');
            $table->foreignId('sent_to_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('sent_to_user_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgr_events');
    }
};
