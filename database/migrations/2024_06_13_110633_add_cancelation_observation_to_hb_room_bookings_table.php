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
        Schema::table('hb_room_bookings', function (Blueprint $table) {
            $table->text('cancelation_observation')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hb_room_bookings', function (Blueprint $table) {
            $table->dropColumn('cancelation_observation');
        });
    }
};
