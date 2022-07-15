<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInvInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_inventories', function (Blueprint $table) {
            $table->integer('status')->nullable()->after('po_date');
            $table->text('observations')->nullable()->after('status');
            $table->timestamp('discharge_date')->nullable()->after('observations');
            $table->string('act_number', 255)->nullable()->after('discharge_date');
            $table->string('depreciation', 255)->nullable()->after('act_number');
            $table->string('number', 255)->change();

            $table->foreignId('user_responsible_id')->after('request_user_id')->nullable()->constrained('users');
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
