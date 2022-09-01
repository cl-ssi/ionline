<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRealSignerIdToDocSignaturesFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures_flows', function (Blueprint $table) {
            $table->unsignedBigInteger('real_signer_id')->after('user_id')->nullable();
            $table->foreign('real_signer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_signatures_flows', function (Blueprint $table) {
            $table->dropForeign(['real_signer_id']);
            $table->dropColumn('real_signer_id');
        });
    }
}
