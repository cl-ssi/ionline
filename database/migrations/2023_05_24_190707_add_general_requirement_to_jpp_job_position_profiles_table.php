<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneralRequirementToJppJobPositionProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jpp_job_position_profiles', function (Blueprint $table) {
            $table->longText('general_requirement')->after('staff_decree_by_estament_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jpp_job_position_profiles', function (Blueprint $table) {
            $table->dropColumn('general_requirement');
        });
    }
}
