<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvaluatedSectionStatesToIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->string('evaluated_section_states')->after('weighting_by_section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropColumn('evaluated_section_states');
        });
    }
}
