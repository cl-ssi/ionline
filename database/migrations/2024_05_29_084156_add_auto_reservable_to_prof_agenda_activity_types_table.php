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
        Schema::table('prof_agenda_activity_types', function (Blueprint $table) {
            $table->boolean('auto_reservable')->default(0)->after('maximum_allowed_per_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prof_agenda_activity_types', function (Blueprint $table) {
            $table->dropColumn('auto_reservable');
        });
    }
};
