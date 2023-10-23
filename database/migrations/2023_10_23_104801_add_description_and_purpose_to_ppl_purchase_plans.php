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
            $table->string('purpose')->after('user_responsible_id')->nullable();
            $table->string('description')->after('user_responsible_id')->nullable();
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
            $table->dropColumn('description');
            $table->dropColumn('purpose');
        });
    }
};
