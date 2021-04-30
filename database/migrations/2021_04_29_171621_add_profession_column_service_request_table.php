<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessionColumnServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_service_requests', function (Blueprint $table) {
        $table->foreignId('profession_id')->nullable()->after('establishment_id');
        $table->foreign('profession_id')->references('id')->on('cfg_professions');
        $table->string('objectives')->after('profession_id')->nullable();
        $table->string('resolve')->after('objectives')->nullable();
        $table->string('additional_benefits')->after('resolve')->nullable();
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
        $table->dropForeign(['profession_id']);
        $table->dropColumn('profession_id');
        $table->dropColumn('objectives');
        $table->dropColumn('resolve');
        $table->dropColumn('additional_benefits');
      });
    }
}
