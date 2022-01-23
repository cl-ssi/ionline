<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcumLastYearToIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->integer('numerator_acum_last_year')->nullable()->after('numerator_cols');
            $table->integer('denominator_acum_last_year')->nullable()->after('denominator_cols');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropColumn(['numerator_acum_last_year', 'denominator_acum_last_year']);
        });
    }
}
