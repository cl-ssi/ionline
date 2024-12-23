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
        Schema::create('cfg_professions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('estament_id')->default(1)->constrained('cfg_estaments');
            $table->string('category')->nullable();
            $table->string('estamento')->nullable();
            $table->string('sirh_plant')->nullable();
            $table->string('sirh_profession')->nullable();
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
        Schema::dropIfExists('cfg_professions');
    }
};
