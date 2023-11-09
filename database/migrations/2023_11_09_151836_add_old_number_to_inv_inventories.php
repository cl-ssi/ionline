<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_inventories', function (Blueprint $table) {
            $table->string('old_number', 255)->after('number')->nullable();
        });
        Schema::table('inv_inventory_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_id')->nullable(false)->change();
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
            $table->dropColumn('old_number');
        });

        Schema::table('inv_inventory_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('inventory_id')->nullable()->change();
        });
    }
};
