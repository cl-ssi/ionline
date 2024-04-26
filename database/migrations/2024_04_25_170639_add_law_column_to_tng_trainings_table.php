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
        Schema::table('tng_trainings', function (Blueprint $table) {
            $table->string('law')->after('estament_id')->nullable();
            $table->string('work_hours')->after('degree')->nullable();
            $table->string('online_type')->after('mechanism')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tng_trainings', function (Blueprint $table) {
            $table->dropColumn('law');
            $table->dropColumn('work_hours');
            $table->dropColumn('online_type');
        });
    }
};
