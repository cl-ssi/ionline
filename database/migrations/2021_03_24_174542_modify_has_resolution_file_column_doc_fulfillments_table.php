<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyHasResolutionFileColumnDocFulfillmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_fulfillments', function (Blueprint $table) {
            $table->renameColumn('has_resolution_file', 'payment_ready');
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
            $table->renameColumn('payment_ready', 'has_resolution_file');
        });
    }
}
