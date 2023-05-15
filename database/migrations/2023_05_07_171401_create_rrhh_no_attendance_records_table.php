<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrhhNoAttendanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_no_attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->datetime('date');
            $table->string('observation');
            $table->foreignId('authority_id')->constrained('users');
            $table->string('authority_observation')->nullable();
            $table->datetime('authority_at')->nullable();
            $table->boolean('status')->nullable()->default(null);
            $table->foreignId('rrhh_user_id')->nullable()->constrained('users');
            $table->timestamp('rrhh_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_no_attendance_records');
    }
}
