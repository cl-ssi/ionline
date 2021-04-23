<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleDetailColumnServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_service_requests', function (Blueprint $table) {
          $table->string('schedule_detail')->after('working_day_type')->nullable();
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
          $table->dropColumn('schedule_detail');
      });
    }
}
