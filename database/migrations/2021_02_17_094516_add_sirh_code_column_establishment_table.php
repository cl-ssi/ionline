<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSirhCodeColumnEstablishmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('establishments', function (Blueprint $table) {
          $table->integer('sirh_code')->nullable()->after('deis');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('establishments', function (Blueprint $table) {
          $table->dropColumn('sirh_code');
      });
    }
}
