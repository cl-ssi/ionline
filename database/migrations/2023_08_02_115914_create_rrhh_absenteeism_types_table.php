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
        Schema::create('rrhh_absenteeism_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('discount')->nullable();
            $table->boolean('half_day')->nullable();
            $table->boolean('count_business_days')->nullable();
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
        Schema::dropIfExists('rrhh_absenteeism_types');
    }
};
