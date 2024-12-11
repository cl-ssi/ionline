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
        Schema::create('agr_addendums', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('file')->nullable();
            $table->integer('res_number')->nullable();
            $table->date('res_date')->nullable();
            $table->string('res_file')->nullable();
            $table->foreignId('agreement_id')->constrained('agr_agreements');
            $table->foreignId('file_to_endorse_id')->constrained('doc_signatures_files');
            $table->foreignId('file_to_sign_id')->nullable()->constrained('doc_signatures_files');
            $table->foreignId('referrer_id')->nullable()->constrained('users');
            $table->foreignId('director_signer_id')->nullable()->constrained('agr_signers');
            $table->string('representative')->nullable();
            $table->string('representative_rut')->nullable();
            $table->string('representative_appellative')->nullable();
            $table->string('representative_decree')->nullable();
            $table->foreignId('document_id')->nullable()->constrained('documents');
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
        Schema::dropIfExists('agr_addendums');
    }
};
