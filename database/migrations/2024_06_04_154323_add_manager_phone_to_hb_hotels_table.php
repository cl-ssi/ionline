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
        Schema::table('hb_hotels', function (Blueprint $table) {
            $table->string('manager_phone')->after('manager_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hb_hotels', function (Blueprint $table) {
            $table->dropColumn('manager_phone');
        });
    }
};
