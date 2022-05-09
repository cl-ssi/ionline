<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWreControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wre_controls', function (Blueprint $table) {
            $table->id();

            $table->boolean('type')->nullable(); // 1:ingreso 0:egreso
            $table->boolean('adjust_inventory')->nullable(); // 1: Es un Ajuste de Inventenario
                                                                // 0: No es Un Ajuste de Inventario
            $table->date('date')->nullable();
            $table->text('note')->nullable();

            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('program_id')->nullable()->constrained('cfg_programs');
            $table->foreignId('origin_id')->nullable()->constrained('wre_origins');
            $table->foreignId('destination_id')->nullable()->constrained('wre_destinations');

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
        Schema::dropIfExists('wre_controls');
    }
}
