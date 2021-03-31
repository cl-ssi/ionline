<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressPhoneUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          //
          $table->string('address')->after('gender')->nullable();
          $table->string('phone_number')->after('address')->nullable();
          $table->unsignedBigInteger('country_id')->after('phone_number')->nullable();

          $table->foreign('country_id')->references('id')->on('countries');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          //
          $table->dropColumn('address');
          $table->dropColumn('phone_number');
          $table->dropColumn('country_id');
      });
    }
}
