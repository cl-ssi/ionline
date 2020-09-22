<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentFkFrmDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frm_deliveries', function (Blueprint $table) {
            $table->bigInteger('document_id')->unsigned()->nullable();
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_deliveries', function (Blueprint $table) {
            $table->dropForeign('frm_deliveries_document_id_foreign');
            $table->dropColumn('document_id');
        });
    }
}
