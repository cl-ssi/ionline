<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFusionAtToResComputers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('res_computers', function (Blueprint $table) {
            $table->timestamp('fusion_at')->after('place_id')->nullable();
            $table->foreignId('inventory_id')
                ->after('place_id')
                ->nullable()
                ->constrained('inv_inventories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('res_computers', function (Blueprint $table) {
            //
            $table->dropColumn(['fusion_at']);
            $table->dropIndex(['inventory_id']);
            $table->dropColumn(['inventory_id']);
        });
    }
}
