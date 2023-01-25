<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisposePrecursorToDrgReceptionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drg_reception_items', function (Blueprint $table) {
            $table->boolean('dispose_precursor')
                ->nullable()
                ->after('result_substance_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drg_reception_items', function (Blueprint $table) {
            $table->dropColumn('dispose_precursor');
        });
    }
}
