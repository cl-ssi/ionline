<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeactivatedAndSoftDeleteToRrhhSubrogations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_subrogations', function (Blueprint $table) {
            //
            $table->boolean('deactivated')->default(0)->after('organizational_unit_id');
            $table->softDeletes()->after('updated_at');
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
            //
            $table->dropColumn('deactivated');
            $table->dropSoftDeletes();
        });
    }
}
