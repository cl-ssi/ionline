<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginMeasuresToProEmergenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_emergencies', function (Blueprint $table) {
            $table->string('another_name')->nullable()->after('name');
            $table->string('origin')->after('another_name');
            $table->text('measures')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_emergencies', function (Blueprint $table) {
            $table->dropColumn(['another_name','origin', 'measures']);
        });
    }
}
