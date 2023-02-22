<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGradeToAlwAllowances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alw_allowances', function (Blueprint $table) {
            $table->string('grade')->after('allowance_value_id')->nullable();
            $table->string('position')->after('contractual_condition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alw_allowances', function (Blueprint $table) {
            $table->dropColumn('grade');
            $table->dropColumn('position');
        });
    }
}
