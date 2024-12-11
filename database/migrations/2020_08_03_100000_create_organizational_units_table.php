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
        Schema::create('organizational_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('level')->nullable();
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->string('sirh_function')->nullable();
            $table->string('sirh_ou_id')->nullable();
            $table->string('sirh_cost_center')->nullable();
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
        Schema::dropIfExists('organizational_units');
    }
};
