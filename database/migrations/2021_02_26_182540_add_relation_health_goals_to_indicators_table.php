<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationHealthGoalsToIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->float('number', 4, 2)->change();
            $table->dropForeign('indicators_comges_id_foreign');
            $table->renameColumn('comges_id', 'indicatorable_id');
            $table->string('indicatorable_type');
            $table->text('numerator_cods')->after('numerator_source')->nullable();
            $table->text('denominator_cods')->after('denominator_source')->nullable();
            $table->text('numerator_cols')->after('numerator_cods')->nullable();
            $table->text('denominator_cols')->after('denominator_cods')->nullable();
            $table->string('goal')->nullable();
            $table->float('weighting', 6, 2)->nullable();
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
            $table->tinyInteger('number')->change();
            $table->renameColumn('indicatorable_id', 'comges_id');
            $table->foreign('comges_id')->references('id')->on('ind_comges');
            $table->dropColumn(['indicatorable_type','numerator_cods','numerator_cols','denominator_cods','denominator_cols','goal','weighting']);
        });
    }
}
