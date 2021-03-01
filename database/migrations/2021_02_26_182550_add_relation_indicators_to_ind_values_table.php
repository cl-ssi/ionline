<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationIndicatorsToIndValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ind_values', function (Blueprint $table) {
            $table->dropForeign('ind_values_action_id_foreign');
            $table->renameColumn('action_id', 'valueable_id');
            $table->string('valueable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ind_values', function (Blueprint $table) {
            $table->renameColumn('valueable_id', 'action_id');
            $table->foreign('action_id')->references('id')->on('ind_actions');
            $table->dropColumn('valueable_type');
        });
    }
}
