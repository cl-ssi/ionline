<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstRequestSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_request_signs', function (Blueprint $table) {
            $table->id();

            //Firmas en filas
            $table->integer('position');
            $table->string('ou_alias');
            $table->foreignId('organizational_unit_id');
            $table->foreignId('user_id')->nullable();
            $table->enum('request_status',['pending', 'accepted', 'rejected', 'observations'])->nullable();
            $table->longText('observation')->nullable();
            $table->dateTime('date_sign')->nullable();

            $table->foreignId('request_replacement_staff_id');

            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('user_id')->references('id')->on('users');


            $table->foreign('request_replacement_staff_id')->references('id')->on('rst_request_replacement_staff');

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
        Schema::dropIfExists('rst_request_signs');
    }
}
