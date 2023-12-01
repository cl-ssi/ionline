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


        DB::table('fin_dtes')->update(['reason_rejection' => DB::raw('confirmation_observation')]);

        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->dropColumn('confirmation_observation');
        });

        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->renameColumn('confirmation_user_id', 'completed_user_id');
            $table->renameColumn('confirmation_ou_id', 'completed_ou_id');
            $table->renameColumn('confirmation_at', 'completed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //proceso de crear confirmacion nuevamente
            $table->addColumn('confirmation_observation', 'string')->nullable();
            $table->update(['confirmation_observation' => DB::raw('reason_rejection')]);
            //
            $table->renameColumn('completed_user_id', 'confirmation_user_id');
            $table->renameColumn('completed_ou_id', 'confirmation_ou_id');
            $table->renameColumn('completed_at', 'confirmation_at');
        });
    }
};
