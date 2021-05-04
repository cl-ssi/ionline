<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileToSignToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('file_to_sign_id')->after('organizational_unit_id')->nullable();
            $table->foreign('file_to_sign_id')->references('id')->on('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_to_documents', function (Blueprint $table) {
            $table->dropForeign(['file_to_sign_id']);
            $table->dropColumn('file_to_sign_id');
        });
    }
}
