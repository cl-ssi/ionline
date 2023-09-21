<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->string('cenabast_reception_file')->after('cenabast')->nullable();
            $table->string('cenabast_signed_pharmacist')->after('cenabast_reception_file')->default(0);
            $table->string('cenabast_signed_boss')->after('cenabast_signed_pharmacist')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
        });
    }
};
