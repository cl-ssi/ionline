<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipDocSignaturesToAgrAgreements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->foreignId('file_to_endorse_id')->after('establishment_list')->nullable();
            $table->foreign('file_to_endorse_id')->references('id')->on('doc_signatures_files');
            $table->foreignId('file_to_sign_id')->after('file_to_endorse_id')->nullable();
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
        Schema::table('agr_agreements', function (Blueprint $table) {
            $table->dropForeign(['file_to_endorse_id', 'file_to_sign_id']);
            $table->dropColumn(['file_to_endorse_id', 'file_to_sign_id']);
        });
    }
}
