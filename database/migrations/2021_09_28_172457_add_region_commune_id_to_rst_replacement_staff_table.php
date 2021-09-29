<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionCommuneIdToRstReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_replacement_staff', function (Blueprint $table) {
            $table->foreignId('region_id')->after('telephone2')->nullable();
            $table->foreignId('commune_id')->after('region_id')->nullable();

            $table->foreign('region_id')->references('id')->on('cl_regions');
            $table->foreign('commune_id')->references('id')->on('cl_communes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_replacement_staff', function (Blueprint $table) {
            $table->dropColumn('region_id');
            $table->dropColumn('commune_id');
        });
    }
}
