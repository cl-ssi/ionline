<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignaturesFileIdToRstRequestReplacementStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->foreignId('signatures_file_id')->after('budget_item_id')->nullable()->constrained('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->dropForeign(['signature_id']);
            $table->dropColumn(['signature_id']);
        });
    }
}
