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
        Schema::table('alw_allowances', function (Blueprint $table) {
            $table->decimal('total_half_days', 3, 2)->after('total_days')->nullable();
            $table->decimal('fifty_percent_total_days', 3, 2)->after('total_half_days')->nullable();
            $table->decimal('fifty_percent_day_value', 8, 2)->after('half_day_value')->nullable();
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
            $table->dropForeign(['total_half_days']);
            $table->dropColumn('total_half_days');
            $table->dropForeign(['fifty_percent_total_days']);
            $table->dropColumn('fifty_percent_total_days');
            $table->dropForeign(['fifty_percent_day_value']);
            $table->dropColumn('fifty_percent_day_value');
        });
    }
};
