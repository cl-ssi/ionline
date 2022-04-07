<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSirhColumnsProfessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('cfg_professions', function (Blueprint $table) {
          $table->string('sirh_plant')->after('estamento')->nullable();
          $table->string('sirh_profession')->after('sirh_plant')->nullable();
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('cfg_professions', function (Blueprint $table) {
          $table->dropColumn(['sirh_plant', 'sirh_profession']);
      });
    }
}
