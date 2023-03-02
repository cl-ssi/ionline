<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCompletedInvoicesToWreControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            $table->boolean('completed_invoices')
                ->after('status')
                ->nullable();
        });

        DB::statement("UPDATE wre_controls SET completed_invoices = 0 WHERE type = 1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
