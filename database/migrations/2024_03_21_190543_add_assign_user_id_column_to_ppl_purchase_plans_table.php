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
        Schema::table('ppl_purchase_plans', function (Blueprint $table) {
            $table->foreignId('assign_user_id')->after('status')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppl_purchase_plans', function (Blueprint $table) {
            $table->dropForeign(['assign_user_id']);
            $table->dropColumn('assign_user_id');
        });
    }
};
