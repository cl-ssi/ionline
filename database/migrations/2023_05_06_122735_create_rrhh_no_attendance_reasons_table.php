<?php

use App\Models\Rrhh\Attendance\Reason;
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
        Schema::create('rrhh_no_attendance_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Reason::create([
            'name' => 'Otro',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_no_attendance_reasons');
    }
};
