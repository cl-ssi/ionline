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
        Schema::create('rrhh_shift_day_hitory_of_changes', function (Blueprint $table) {
            $table->id();
            $table->integer('previous_user')->nullable();
            $table->integer('current_user')->nullable();
            $table->string('previous_value')->nullable();
            $table->string('current_value');
            $table->date('day');
            $table->integer('modified_by');
            $table->integer('change_type');
            $table->longText('commentary');
            $table->foreignId('shift_user_day_id')->constrained('rrhh_shift_user_days');

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
        Schema::dropIfExists('rrhh_shift_day_hitory_of_changes');
    }
};
