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
        Schema::table('prof_agenda_open_hours', function (Blueprint $table) {
            $table->boolean('assistance')->after('deleted_bloqued_observation')->nullable();
            $table->string('absence_reason')->after('assistance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prof_agenda_open_hours', function (Blueprint $table) {
            $table->dropColumn('assistance');
            $table->dropColumn('absence_reason');
        });
    }
};
