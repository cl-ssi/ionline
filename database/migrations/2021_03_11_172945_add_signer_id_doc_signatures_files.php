<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignerIdDocSignaturesFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures_files', function (Blueprint $table) {
            $table->foreignId('signer_id')->after('md5_signed_file')->nullable();
            $table->foreign('signer_id')->references('id')->on('users');
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
            $table->dropForeign(['signer_id']);
            $table->dropColumn('signer_id');
        });
    }
}
