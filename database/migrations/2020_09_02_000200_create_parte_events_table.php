<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParteEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parte_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parte_id');
            $table->unsignedBigInteger('organizational_unit_id')->comment('destino')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('action', ['Ingresado','Recepcionado','Derivado','Respondido','Archivado','Anulado','Comentado']);
            $table->string('comment')->nullable();
            // $table->string('file')->nullable();
            // $table->boolean('active')->nullable();
            // $table->unsignedInteger('parte_events_id')->nullable();
            $table->timestamps();

            $table->foreign('parte_id')->references('id')->on('partes');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('parte_events_id')->references('id')->on('parte_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parte_events');
    }
}
