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
            $table->foreignId('profesional_id')->nullable()->constrained('users')->after('patient_id');
            $table->foreignId('profession_id')->nullable()->constrained('cfg_professions')->after('patient_id');
            $table->foreignId('activity_type_id')->nullable()->constrained('prof_agenda_activity_types')->after('profession_id');
            $table->unsignedBigInteger('proposal_detail_id')->nullable()->change();
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
            $table->dropForeign('prof_agenda_open_hours_profesional_id_foreign');
            $table->dropForeign('prof_agenda_open_hours_profession_id_foreign');
            $table->dropColumn('profesional_id');
            $table->dropColumn('profession_id');
            $table->dropColumn('activity_type_id');
        });
    }
};
