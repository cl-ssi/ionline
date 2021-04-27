<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhysicalFormatToPartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partes', function (Blueprint $table) {
            //
            $table->boolean('physical_format')->after('important')->nullable();
            $table->unsignedBigInteger('received_by_id')->after('physical_format')->nullable();
            $table->foreign('received_by_id')->references('id')->on('users');
            $table->datetime('reception_date')->after('received_by_id')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partes', function (Blueprint $table) {
            //
            $table->dropColumn('physical_format');
            $table->dropForeign(['received_by_id']);
            $table->dropColumn('received_by_id');
            $table->dropColumn('reception_date');
            
        });
    }
}
