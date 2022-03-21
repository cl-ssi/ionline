<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToIndHealthGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ind_health_goals', function (Blueprint $table) {
            $table->enum('status',['development', 'review', 'verified'])->default('development')->after('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ind_health_goals', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
