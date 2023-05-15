<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchitecturalDesignCodeToCfgPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_places', function (Blueprint $table) {
            //
            $table->string('architectural_design_code')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_places', function (Blueprint $table) {
            //
            $table->dropColumn('architectural_design_code');
        });
    }
}
