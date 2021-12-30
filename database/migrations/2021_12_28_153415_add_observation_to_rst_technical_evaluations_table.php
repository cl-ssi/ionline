<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationToRstTechnicalEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_technical_evaluations', function (Blueprint $table) {
            $table->string('reason')->nullable()->after('technical_evaluation_status');
            $table->text('observation')->nullable()->after('reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_technical_evaluations', function (Blueprint $table) {
            $table->dropColumn('reason');
            $table->dropColumn('observation');
        });
    }
}
