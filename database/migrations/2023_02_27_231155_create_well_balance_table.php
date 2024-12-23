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
        Schema::create('well_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('ano')->nullable();
            $table->integer('mes')->nullable();
            $table->string('tipo')->nullable();
            $table->string('codigo')->nullable();
            $table->string('titulo')->nullable();
            $table->string('item')->nullable();
            $table->string('asignacion')->nullable();
            $table->string('glosa')->nullable();
            $table->integer('inicial')->nullable();
            $table->integer('traspaso')->nullable();
            $table->integer('ajustado')->nullable();
            $table->integer('ejecutado')->nullable();
            $table->integer('saldo')->nullable();
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
        Schema::dropIfExists('well_balance');
    }
};
