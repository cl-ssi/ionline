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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->datetime('record_at');
            $table->boolean('type');
            $table->enum('verification', ['iOnline', 'Finger', 'Password'])->default('iOnline');
            $table->string('clock_ip')->nullable();
            $table->string('clock_serial')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('establishment_id')->constrained();
            $table->foreignId('rrhh_user_id')->nullable()->constrained('users');
            $table->dateTime('sirh_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
