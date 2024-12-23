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
        Schema::create('cfg_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('module', 50);
            $table->string('parameter');
            $table->string('value');
            $table->string('description')->nullable();
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
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
        Schema::dropIfExists('cfg_parameters');
    }
};
