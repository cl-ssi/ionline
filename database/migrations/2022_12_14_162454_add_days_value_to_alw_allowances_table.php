<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysValueToAlwAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alw_allowances', function (Blueprint $table) {
            $table->dropColumn('from_half_day');
            $table->dropColumn('to_half_day');

            $table->decimal('total_days', 3, 2)->after('to')->nullable();
            $table->integer('day_value')->after('total_days')->nullable();
            $table->decimal('half_day_value', 8, 2)->after('day_value')->nullable();
            $table->integer('total_value')->after('half_day_value')->nullable();
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
            $table->dropColumn('total_days');
            $table->dropColumn('day_value');
            $table->dropColumn('half_day_value');
            $table->dropColumn('total_value');
        });
    }
}
