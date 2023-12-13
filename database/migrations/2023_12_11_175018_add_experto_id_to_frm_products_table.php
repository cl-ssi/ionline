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
        Schema::table('frm_products', function (Blueprint $table) {
            $table->integer('experto_id')->nullable()->after('program_id');
            // $table->unique(['barcode','pharmacy_id'],'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_products', function (Blueprint $table) {
            $table->dropColumn('experto_id');
        });
    }
};
