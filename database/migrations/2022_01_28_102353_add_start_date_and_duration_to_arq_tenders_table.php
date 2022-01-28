<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartDateAndDurationToArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('supplier_id');
            $table->integer('duration')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'duration']);
        });
    }
}
