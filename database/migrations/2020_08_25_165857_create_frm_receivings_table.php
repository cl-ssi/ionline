<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_receivings', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->dateTime('date'); //fecha xfecha
            $table->unsignedBigInteger('establishment_id'); //origen
            $table->unsignedBigInteger('pharmacy_id'); //destino
            $table->longText('notes')->nullable(); //notas
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('establishment_id')->references('id')->on('frm_establishments');
            $table->foreign('pharmacy_id')->references('id')->on('frm_pharmacies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_receivings');
    }
}
