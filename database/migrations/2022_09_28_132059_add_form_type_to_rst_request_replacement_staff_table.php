<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormTypeToRstRequestReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->string('form_type')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->dropColumn(['form_type']);
        });
    }
}
