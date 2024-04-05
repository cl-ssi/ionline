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
        Schema::table('fin_reception_items', function (Blueprint $table) {
            $table->integer('PrecioExento')->after('PrecioNeto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_reception_items', function (Blueprint $table) {
            //
            $table->dropColumn('PrecioExento');
        });
    }
};
