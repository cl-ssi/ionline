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
        Schema::table('rrhh_absenteeism_types', function (Blueprint $table) {
            $table->float('over', 15, 2)->after('count_business_days')->nullable(); //sobre
            $table->float('from', 15, 2)->after('count_business_days')->nullable(); //desde
        });

        Schema::dropIfExists('well_ami_discount_conditions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_absenteeism_types', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('over');
        });
    }
};
