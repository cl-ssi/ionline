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
        Schema::create('pro_emergencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('another_name')->nullable();
            $table->string('origin');
            $table->text('description');
            $table->text('measures');
            $table->tinyInteger('frecuency');
            $table->tinyInteger('impact_level');
            $table->tinyInteger('ss_rol');
            $table->foreignId('programming_id')->constrained('pro_programmings');
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
        Schema::dropIfExists('pro_emergencies');
    }
};
