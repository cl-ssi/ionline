<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractualConditionColumnServicerequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_service_requests', function (Blueprint $table) {
        $table->string('contractual_condition', 100)->after('contract_type')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('doc_service_requests', function (Blueprint $table) {
          $table->dropColumn('contractual_condition');
      });
    }
}
