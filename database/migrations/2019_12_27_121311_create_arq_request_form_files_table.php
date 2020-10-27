<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqRequestFormFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_request_form_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file')->nullable();
            $table->string('name')->nullable();
            $table->unsignedInteger('request_form_id')->unsigned()->nullable();//id del formulario de requerimiento.
            $table->unsignedInteger('user_id')->nullable();//id del usuario.

            $table->timestamps();
            $table->softDeletes();
            //$table->foreign('ticket_id')->references('id')->on('tik_tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_request_form_files');
    }
}
