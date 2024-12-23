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
        Schema::table('rst_detail_fundaments', function (Blueprint $table) {
            $table->boolean('replacement')->after('fundament_manage_id')->nullable();
            $table->boolean('announcement')->after('replacement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_detail_fundaments', function (Blueprint $table) {
            $table->dropColumn(['replacement']);
            $table->dropColumn(['announcement']);
        });
    }
};
