<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionCommuneIdsToCfgSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_suppliers', function (Blueprint $table) {
            $table->foreignId('region_id')->after('address')->nullable()->constrained('cl_regions');
            $table->foreignId('commune_id')->after('region_id')->nullable()->constrained('cl_communes');
            $table->dropColumn('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_suppliers', function (Blueprint $table) {
            $table->string('city')->nullable()->after('address');
            $table->dropForeign(['region_id', 'commune_id']);
            $table->dropColumn(['region_id', 'commune_id']);
        });
    }
}
