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
        Schema::table('frm_establishments', function (Blueprint $table) {
            $table->dropUnique('frm_establishments_name_unique');
            $table->unique(['name','pharmacy_id'],'frm_establishments_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_establishments', function (Blueprint $table) {
            //
        });
    }
};
