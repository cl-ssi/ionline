<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoicePathFulfillmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table) {
            $table->boolean('has_invoice_file')->after('finances_approver_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table) {
            $table->dropColumn('has_invoice_file');
        });
    }
}
