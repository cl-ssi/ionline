<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldsToInvInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_inventories', function (Blueprint $table) {

            $table->dropForeign(['place_id']);
            $table->dropColumn('place_id');

            $table->dropForeign(['delivered_user_ou_id']);
            $table->dropColumn('delivered_user_ou_id');

            $table->dropForeign(['delivered_user_id']);
            $table->dropColumn('delivered_user_id');

            $table->dropColumn([
                'reception_confirmation',
                'deliver_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_inventories', function (Blueprint $table) {
            //
        });
    }
}
