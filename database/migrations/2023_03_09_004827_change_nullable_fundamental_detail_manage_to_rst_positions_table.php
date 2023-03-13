<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFundamentalDetailManageToRstPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_positions', function (Blueprint $table) {
            $table->unsignedBigInteger('fundament_detail_manage_id')->nullable()->change();
            $table->dropForeign(['fundament_detail_manage_id']);
            $table->foreign('fundament_detail_manage_id')->references('id')->on('rst_fundament_detail_manages');

            $table->dropColumn('request_verification_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_positions', function (Blueprint $table) {
            $table->unsignedBigInteger('fundament_detail_manage_id')->nullable(false)->change();
            $table->dropForeign(['fundament_detail_manage_id']);
            $table->foreign('fundament_detail_manage_id')->references('id')->on('rst_fundament_detail_manages');

            $table->string('request_verification_file')->nullable()->after('job_profile_file');
        });
    }
}
