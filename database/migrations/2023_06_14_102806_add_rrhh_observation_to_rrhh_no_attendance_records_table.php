<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRrhhObservationToRrhhNoAttendanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_no_attendance_records', function (Blueprint $table) {
            $table->boolean('rrhh_status')->after('rrhh_at')->nullable();
            $table->string('rrhh_observation')->after('rrhh_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_no_attendance_records', function (Blueprint $table) {
            $table->dropColumn('rrhh_observation');
            $table->dropColumn('rrhh_status');
        });
    }
}
