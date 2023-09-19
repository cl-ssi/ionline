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
        Schema::table('wre_controls', function (Blueprint $table) {
            //
            $table->foreignId('visation_warehouse_manager_user_id')->after('visation_contract_manager_rejection_observation')->nullable()->constrained('users');
            $table->foreignId('visation_warehouse_manager_ou')->after('visation_warehouse_manager_user_id')->nullable()->constrained('organizational_units');
            $table->datetime('visation_warehouse_manager_at')->after('visation_warehouse_manager_ou')->nullable();
            $table->boolean('visation_warehouse_manager_status')->after('visation_warehouse_manager_at')->nullable();
            $table->text('visation_warehouse_manager_rejection_observation')->after('visation_contract_manager_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            //            
            $table->dropForeign(['visation_warehouse_manager_user_id']);
            $table->dropColumn('visation_warehouse_manager_user_id');
            $table->dropForeign(['visation_warehouse_manager_ou']);
            $table->dropColumn('visation_warehouse_manager_ou');
            $table->dropColumn('visation_warehouse_manager_at');
            $table->dropColumn('visation_warehouse_manager_status');
            $table->dropColumn('visation_warehouse_manager_rejection_observation');
        });
    }
};
