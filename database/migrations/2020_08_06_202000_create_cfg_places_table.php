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
        Schema::create('cfg_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable()->default(null);
            $table->string('architectural_design_code')->nullable();
            $table->integer('floor_number')->nullable();
            $table->foreignId('location_id')->constrained('cfg_locations')->onDelete('restrict');
            $table->foreignId('establishment_id')->constrained('establishments');
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
        Schema::dropIfExists('cfg_places');
    }
};
