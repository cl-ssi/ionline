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
            $table->decimal('sixty_percent_total_days', 5, 2)->after('fifty_percent_total_days')->nullable();
            $table->decimal('sixty_percent_day_value', 10, 2)->after('fifty_percent_day_value')->nullable();

            $table->decimal('total_days', 5, 2)->change();
            $table->decimal('total_half_days', 5, 2)->change();
            $table->decimal('fifty_percent_total_days', 5, 2)->change();

            $table->decimal('half_day_value', 10, 2)->change();
            $table->decimal('fifty_percent_day_value', 10, 2)->change();
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
            $table->dropColumn('sixty_percent_total_days');
            $table->dropColumn('sixty_percent_day_value');
        });
    }
};
