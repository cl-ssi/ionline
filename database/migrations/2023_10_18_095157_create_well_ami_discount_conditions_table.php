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
        Schema::create('well_ami_discount_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absenteeism_type_id')->constrained('rrhh_absenteeism_types');
            $table->float('from', 15, 2)->nullable();
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
        Schema::dropIfExists('well_ami_discount_conditions');
    }
};
