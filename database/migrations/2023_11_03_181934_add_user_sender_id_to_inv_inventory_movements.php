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
        Schema::table('inv_inventory_movements', function (Blueprint $table) {
            $table->foreignId('user_sender_id')->nullable()->after('user_using_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_inventory_movements', function (Blueprint $table) {
            $table->dropForeign(['user_sender_id']);
            $table->dropColumn('user_sender_id');
        });
        
    }
};
