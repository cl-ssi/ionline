<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsServiceRequestsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_service_requests', function (Blueprint $table) {
          $table->softDeletes();
      });

      Schema::table('doc_shift_controls', function (Blueprint $table) {
          $table->softDeletes();
      });

      Schema::table('doc_signature_flow', function (Blueprint $table) {
          $table->softDeletes();
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
          $table->softDeletes();
      });

      Schema::table('doc_shift_controls', function (Blueprint $table) {
          $table->softDeletes();
      });

      Schema::table('doc_signature_flow', function (Blueprint $table) {
          $table->softDeletes();
      });
    }
}
