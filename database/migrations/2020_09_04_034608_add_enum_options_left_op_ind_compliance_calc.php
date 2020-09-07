<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnumOptionsLeftOpIndComplianceCalc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE ind_compliance_calc MODIFY COLUMN left_result_operator ENUM('<','<=','>','>=') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE ind_compliance_calc MODIFY COLUMN left_result_operator ENUM('<','<=') NULL");
    }
}
