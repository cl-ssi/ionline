<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jpp_job_position_profiles', function (Blueprint $table) {
            $table->foreignId('jpp_ou_id')->nullable()->after('ou_creator_id')->constrained('organizational_units');
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
            $table->dropForeign(['jpp_ou_id']);
            $table->dropColumn('jpp_ou_id');
        });
    }
};
