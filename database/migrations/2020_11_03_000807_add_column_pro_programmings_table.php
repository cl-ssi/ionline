<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProProgrammingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programmings', function (Blueprint $table) {
            $table->string('file_a')->nullable()->after('access');
            $table->string('file_b')->nullable()->after('file_a');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_programmings', function (Blueprint $table) {
            $table->dropColumn('file_a');
            $table->dropColumn('file_b');
        });
    }
}
