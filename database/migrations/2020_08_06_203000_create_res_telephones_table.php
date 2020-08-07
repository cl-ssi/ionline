<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('res_telephones', function (Blueprint $table) {
              $table->id();
              $table->integer('number')->unique();
              $table->integer('minsal')->unique();
              $table->macAddress('mac')->unique()->nullable();
              $table->foreignId('place_id')->nullable();
              $table->timestamps();
              $table->softDeletes();

              $table->foreign('place_id')
                    ->references('id')
                    ->on('cfg_places')
                    ->onDelete('restrict');
          });

          Schema::create('res_telephone_user', function (Blueprint $table) {
              $table->foreignId('telephone_id')->unsigned();
              $table->foreign('telephone_id')->references('id')->on('res_telephones')->onDelete('cascade');

              $table->foreignId('user_id')->unsigned();
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('res_telephones');
    }
}
