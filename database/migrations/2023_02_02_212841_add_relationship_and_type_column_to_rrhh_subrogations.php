<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipAndTypeColumnToRrhhSubrogations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_subrogations', function (Blueprint $table) {
            $table->string('type')->after('organizational_unit_id')->nullable();
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_subrogations', function (Blueprint $table) {
            $table->dropForeign(['organizational_unit_id']);
            $table->dropColumn(['type']);
        });
    }
}
