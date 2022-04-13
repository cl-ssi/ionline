<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSirhColumnsOrganizationalUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('organizational_units', function (Blueprint $table) {
        $table->string('sirh_function')->after('establishment_id')->nullable();
        $table->string('sirh_ou_id')->after('sirh_function')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('organizational_units', function (Blueprint $table) {
          $table->dropColumn(['sirh_function', 'sirh_ou_id']);
      });
    }
}
