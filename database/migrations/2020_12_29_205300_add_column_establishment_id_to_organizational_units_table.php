<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEstablishmentIdToOrganizationalUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizational_units', function (Blueprint $table) {
            //
            $table->tinyInteger('level')->nullable()->after('name');;
            $table->unsignedInteger('establishment_id')->nullable()->after('organizational_unit_id');;
            $table->foreign('establishment_id')->references('id')->on('establishments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizational_units', function (Blueprint $table) {
            //
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
            $table->dropColumn('level');
        });
    }
}
