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
            $table->longText('description')->nullable()->after('reservable');
            $table->boolean('allow_consecutive_days')->default(false)->after('description');
            $table->integer('maximum_allowed_per_week')->nullable()->after('allow_consecutive_days');
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
            $table->dropColumn('description');
            $table->dropColumn('allow_consecutive_days');
            $table->dropColumn('maximum_allowed_per_week');
        });
    }
};
