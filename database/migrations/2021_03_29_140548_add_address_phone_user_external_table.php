<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressPhoneUserExternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_external', function (Blueprint $table) {
            //
            $table->string('address')->after('gender')->nullable();
            $table->string('phone_number')->after('address')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_external', function (Blueprint $table) {
            //
            $table->dropColumn('address');
            $table->dropColumn('phone_number');
        });
    }
}
