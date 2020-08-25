<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_dispatches', function (Blueprint $table) {

          $table->bigIncrements('id');
          $table->dateTime('date'); //fecha xfecha
          $table->unsignedBigInteger('pharmacy_id'); //origen
          $table->unsignedBigInteger('establishment_id');
          $table->longText('notes')->nullable(); //notas
          $table->unsignedBigInteger('user_id');
          $table->boolean('sendC19');

          $table->timestamps();
          $table->softDeletes();

          $table->foreign('pharmacy_id')->references('id')->on('frm_pharmacies');
          $table->foreign('establishment_id')->references('id')->on('frm_establishments');
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
        Schema::dropIfExists('frm_dispatches');
    }
}
