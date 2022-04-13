<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSirhCostCenterColumnOrganizationalUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('organizational_units', function (Blueprint $table) {
        $table->string('sirh_cost_center')->after('sirh_ou_id')->nullable();
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
          $table->dropColumn(['sirh_cost_center']);
      });
    }
}
