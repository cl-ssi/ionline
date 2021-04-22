<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureIdToDocSignaturesFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures_files', function (Blueprint $table) {
            $table->foreignId('signature_id')->nullable()->after('md5_signed_file');
            $table->foreign('signature_id')->references('id')->on('doc_signatures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_signatures_files', function (Blueprint $table) {
            $table->dropForeign(['signature_id']);
            $table->dropColumn('signature_id');
        });
    }
}
