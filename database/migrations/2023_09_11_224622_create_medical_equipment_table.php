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
        Schema::create('medical_equipment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('clinical_service');
            $table->string('precint')->nullable();
            $table->string('class');
            $table->string('subclass');
            $table->string('equipment_name');
            $table->string('brand');
            $table->string('model');
            $table->string('serial');
            $table->integer('inventory_number');
            $table->string('adquisition_year');
            $table->integer('lifespan');
            $table->integer('remaining_lifespan');
            $table->string('ownership');
            $table->string('state');
            $table->string('level')->nullable();
            $table->boolean('under_warranty');
            $table->string('warranty_expiration_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_equipment');
    }
};
