<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqRequestFormEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_request_form_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('comment');
            $table->string('type');
            $table->string('status')->nullable();
            $table->unsignedInteger('request_form_id')->unsigned()->nullable();//id del formulario de requerimiento.
            $table->unsignedInteger('user_id')->nullable();//id del usuario.

            $table->timestamps();
            $table->softDeletes();
            
            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_request_form_events');
    }
}
