<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignedCertificateToPsiResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures', function (Blueprint $table){
            $table->boolean('visatorAsSignature')->after('verification_code')->nullable();
        });

        Schema::table('psi_results', function (Blueprint $table) {
            $table->foreignId('signed_certificate_id')->after('request_id')->nullable();
            $table->foreign('signed_certificate_id')->references('id')->on('doc_signatures_files');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_signatures_files', function (Blueprint $table){
            $table->dropColumn('visatorAsSignature');
        });

        Schema::table('psi_results', function (Blueprint $table) {
            $table->dropForeign(['signed_certificate_id']);
            $table->dropColumn('signed_certificate_id');
        });
    }
}
