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
        Schema::create('rst_staff_manages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizational_unit_id');
            $table->foreignId('replacement_staff_id');

            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('replacement_staff_id')->references('id')->on('rst_replacement_staff');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rst_staff_manages');
    }
};
