<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionToIndAttachedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ind_attached_files', function (Blueprint $table) {
            $table->unsignedTinyInteger('section')->nullable()->after('establishment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ind_attached_files', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }
}
