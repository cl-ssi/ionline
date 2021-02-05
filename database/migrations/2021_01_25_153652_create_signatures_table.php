<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ou_id');
            $table->foreignId('responsable_id');
            $table->datetime('request_date');
            $table->string('document_type', 255)->nullable(); //carta, circular, convenios, etc.
            $table->boolean('reserved')->nullable();
            $table->string('subject', 255)->nullable(); //honorarios, covid19, etc.
            $table->string('description', 255)->nullable();
            $table->string('endorse_type', 255)->nullable(); //tipo de visación
            $table->string('recipients', 255)->nullable(); //destinatarios
            $table->string('distribution', 255)->nullable(); //distribución
            $table->unsignedBigInteger('user_id');
            $table->string('verification_code')->nullable(); /* ej: afo2f42o2f */

            //fk
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('ou_id')->references('id')->on('organizational_units');

            $table->timestamps();
        });

        Schema::create('doc_signatures_flow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('signature_id');
            $table->enum('type', ['visador', 'firmante'])->nullable();
            $table->foreignId('ou_id');
            $table->foreignId('user_id')->nullable();
            $table->tinyInteger('sign_position')->nullable(); //sólo para type Visador

            $table->boolean('status')->nullable(); // Signed 1 Unsigned 0
            $table->datetime('signature_date')->nullable();
            $table->longText('observation')->nullable();

            $table->foreign('signature_id')->references('id')->on('doc_signatures');
            $table->foreign('ou_id')->references('id')->on('organizational_units');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('doc_signatures_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_signatures_flow_id ');
            $table->binary('file');
            $table->enum('file_type', ['documento', 'anexo']);
            $table->binary('signed_file')->nullable();

            $table->foreign('doc_signatures_flow_id')->references('id')->on('doc_signatures_flow');

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
        Schema::dropIfExists('doc_signatures_flow');
        Schema::dropIfExists('doc_signatures');
        Schema::dropIfExists('doc_signatures_files');
    }
}
