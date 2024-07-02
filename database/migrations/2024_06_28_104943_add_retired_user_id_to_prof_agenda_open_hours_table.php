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
            $table->foreignId('external_user_id')->nullable()->after('patient_id')->constrained('prof_agenda_external_users');
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
            $table->dropForeign(['external_user_id']);
            $table->dropColumn('external_user_id');
        });
    }
};
