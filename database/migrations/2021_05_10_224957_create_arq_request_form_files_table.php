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
        Schema::create('arq_request_form_files', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('request_form_id')->unsigned()->nullable(); //id del formulario de requerimiento.
            $table->unsignedBigInteger('user_id')->nullable(); //id del usuario.

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
};
