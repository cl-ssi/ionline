<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstablishmentCommuneToIndValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ind_values', function (Blueprint $table) {
            $table->string('commune')->after('factor')->nullable();
            $table->string('establishment')->after('commune')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ind_values', function (Blueprint $table) {
            $table->dropColumn(['commune', 'establishment']);
        });
    }
}
