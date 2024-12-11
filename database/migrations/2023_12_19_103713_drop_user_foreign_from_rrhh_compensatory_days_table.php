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
        Schema::table('rrhh_compensatory_days', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unique(['user_id', 'request_date', 'start_date', 'end_date'], 'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_compensatory_days', function (Blueprint $table) {
            //
        });
    }
};
