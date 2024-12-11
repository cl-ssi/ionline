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
        Schema::create('att_overtime_refunds', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('organizational_unit_id')->constrained();
            $table->foreignId('boss_id')->constrained('users');
            $table->string('boss_position')->nullable();
            $table->string('grado')->nullable();
            $table->string('planta')->nullable();
            $table->enum('type', ['pay', 'return']);
            $table->text('details')->nullable();
            $table->unsignedInteger('total_minutes_day')->nullable();
            $table->unsignedInteger('total_minutes_night')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('establishment_id')->constrained();
            $table->boolean('rrhh_ok')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('att_overtime_refunds');
    }
};
