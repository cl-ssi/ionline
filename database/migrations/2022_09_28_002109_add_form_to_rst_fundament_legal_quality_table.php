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
        Schema::table('rst_fundament_legal_quality', function (Blueprint $table) {
            $table->boolean('replacement')->after('legal_quality_manage_id')->nullable();
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
        Schema::table('rst_fundament_legal_quality', function (Blueprint $table) {
            $table->dropColumn(['replacement']);
            $table->dropColumn(['announcement']);
        });
    }
};
