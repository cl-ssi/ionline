<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_user_request_of_days', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('commentary')->nullable();
            $table->foreignId('shift_user_day_id')->constrained('rrhh_shift_user_days');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('status_change_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_user_request_of_days');
    }
};
