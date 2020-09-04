<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req_events', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('body');
            $table->enum('status',['creado','respondido','cerrado','derivado','reabierto','en copia']);

            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('from_ou_id')->default(69);

            $table->unsignedBigInteger('to_user_id');
            $table->unsignedBigInteger('to_ou_id');

            $table->unsignedBigInteger('requirement_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('from_ou_id')->references('id')->on('organizational_units');

            $table->foreign('to_user_id')->references('id')->on('users');
            $table->foreign('to_ou_id')->references('id')->on('organizational_units');

            $table->foreign('requirement_id')->references('id')->on('req_requirements');

        });

        Schema::create('req_documents_events', function (Blueprint $table) {
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('document_id')->unsigned();

            $table->foreign('event_id')->references('id')->on('req_events')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->timestamps();
        });

        /*Schema::create('req_events_files', function (Blueprint $table) {
            $table->integer('event_id')->unsigned();
            $table->integer('file_id')->unsigned();

            $table->foreign('event_id')->references('id')->on('req_events')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('req_files')->onDelete('cascade');

            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('req_documents_events');
        Schema::dropIfExists('req_events');
    }
}
