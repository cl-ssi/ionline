<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisatorTypeToDocSignaturesFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures_flows', function (Blueprint $table) {
            $table->enum('visator_type', ['elaborador', 'revisador'])->after('custom_y_axis')->nullable();
            $table->integer('position_visator_type')->after('visator_type')->nullable();
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
            $table->dropColumn('visator_type');
            $table->dropColumn('position_visator_type');
        });
    }
}
