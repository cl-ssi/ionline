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
        Schema::create('rrhh_user_shifttype_months', function (Blueprint $table) {
            $table->id();
            $table->integer('month')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shift_type_id')->constrained('rrhh_shift_types');
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
        Schema::dropIfExists('rrhh_user_shifttype_months');
    }
};
