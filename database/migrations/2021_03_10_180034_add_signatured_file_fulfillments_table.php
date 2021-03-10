<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignaturedFileFulfillmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_fulfillments', function(Blueprint $table){
            $table->foreignId('signatures_file_id')->after('has_invoice_file')->nullable();
            $table->foreign('signatures_file_id')->references('id')->on('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table){
            $table->dropForeign(['signatures_file_id']);
            $table->dropColumn('signatures_file_id');
        });
    }
}
