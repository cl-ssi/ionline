<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeriveDateColumnServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_signature_flow', function (Blueprint $table) {
          $table->datetime('derive_date')->nullable()->after('ou_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('doc_signature_flow', function (Blueprint $table) {
          $table->dropColumn('derive_date');
      });
    }
}
