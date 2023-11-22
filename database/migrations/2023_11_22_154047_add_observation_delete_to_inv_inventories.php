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
        Schema::table('inv_inventories', function (Blueprint $table) {
            $table->string('observation_delete')->nullable(true)->after('printed');
            $table->foreignId('user_delete_id')->after('observation_delete')->nullable(true)->constrained('users');
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
            $table->dropForeign(['user_delete_id']);
            $table->dropColumn(['observation_delete', 'user_delete_id']);
        });
    }
};
