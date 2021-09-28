<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignedRecordIdToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frm_purchases', function (Blueprint $table) {
            $table->foreignId('signed_record_id')->after('user_id')->nullable();
            $table->foreign('signed_record_id')->references('id')->on('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_purchases', function (Blueprint $table) {
            $table->dropForeign(['signed_record_id']);
            $table->dropColumn('signed_record_id');
        });
    }
}
