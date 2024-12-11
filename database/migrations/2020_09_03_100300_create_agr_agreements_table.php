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
        Schema::create('agr_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->nullable()->constrained('agr_agreements');
            $table->date('date');
            $table->smallInteger('period');
            $table->string('file')->nullable();
            $table->string('fileAgreeEnd')->nullable();
            $table->string('fileResEnd')->nullable();
            $table->foreignId('program_id')->nullable()->cosntrained('agr_programs');
            $table->foreignId('commune_id')->constrained('communes');

            $table->smallInteger('quotas');
            $table->integer('total_amount')->nullable();
            $table->string('referente')->nullable();
            $table->foreignId('referrer_id')->nullable()->cosntrained('users');
            $table->foreignId('referrer2_id')->nullable()->constrained('users');
            $table->foreignId('director_signer_id')->nullable()->constrained('agr_signers');

            // MUNICIPALIDAD
            $table->string('representative')->nullable();
            $table->string('representative_rut')->nullable();
            $table->string('representative_appelative')->nullable();
            $table->string('representative_decree')->nullable();
            $table->string('municipality_adress')->nullable();
            $table->string('municipality_rut')->nullable();

            // RESOLUCIÓN
            $table->integer('number')->nullable(); // NÚMERO RESOLUCIÓN DEL CONVENIO
            $table->date('resolution_date')->nullable();

            // RESOLUCIÓN EXCENTA
            $table->integer('res_exempt_number')->nullable(); // NÚMERO RESOLUCIÓN EXCENTA
            $table->date('res_exempt_date')->nullable();

            // RESOLUCIÓN DISTRIBUYE RECURSOS
            $table->integer('res_resource_number')->nullable(); // NÚMERO RESOLUCIÓN DISTRIBUYE RECURSOS
            $table->date('res_resource_date')->nullable();

            // CONVENIOS ESTABLECIMIENTOS
            $table->json('establishment_list')->nullable();
            $table->foreignId('file_to_endorse_id')->nullable()->constrained('doc_signatures_files');
            $table->foreignId('file_to_sign_id')->nullable()->constrained('doc_signatures_files');
            $table->foreignId('document_id')->nullable()->constrained('documents');
            $table->foreignId('res_document_id')->nullable()->constrained('documents');

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
        Schema::dropIfExists('agr_agreements');
    }
};
