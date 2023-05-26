<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonFkToRrhhNoAttendanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_no_attendance_records', function (Blueprint $table) {
            $table->foreignId('reason_id')->after('date')->default(1)->constrained('rrhh_no_attendance_reasons');
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
            $table->dropForeign(['reason_id']);
            $table->dropColumn('reason_id');
        });
    }
}
