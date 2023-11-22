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
            //
            $table->datetime('removal_request_reason_at')->nullable()->after('removal_request_reason');
            $table->boolean('is_removed')->nullable()->default(null)->after('removal_request_reason_at');
            $table->foreignId('removed_user_id')->nullable()->after('is_removed')->constrained('users');
            $table->datetime('removed_at')->nullable()->after('removed_user_id');
            
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
            $table->dropColumn('removal_request_reason_at');
            $table->dropColumn('is_removed');

            $table->dropForeign(['removed_user_id']);
            $table->dropColumn('removed_user_id');

            $table->dropColumn('removed_at');
        });
    }
};
