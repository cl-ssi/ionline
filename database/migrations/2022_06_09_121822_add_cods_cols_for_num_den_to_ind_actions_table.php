<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodsColsForNumDenToIndActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ind_actions', function (Blueprint $table) {
            $table->text('numerator_cods')->after('numerator_source')->nullable();
            $table->text('denominator_cods')->after('denominator_source')->nullable();
            $table->text('numerator_cols')->after('numerator_cods')->nullable();
            $table->text('denominator_cols')->after('denominator_cods')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ind_actions', function (Blueprint $table) {
            $table->dropColumn(['numerator_cods','numerator_cols','denominator_cods','denominator_cols']);
        });
    }
}
