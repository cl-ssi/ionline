<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProProgrammingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pro_programming_items', function (Blueprint $table) {
            $table->enum('activity_type',['Directa','Indirecta','Otra'])->nullable()->after('id');
            $table->enum('workshop',['SI','NO'])->nullable()->after('observation');
            $table->enum('active',['SI','NO'])->nullable()->after('workshop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pro_programming_items', function (Blueprint $table) {
            $table->dropColumn('activity_type');
            $table->dropColumn('workshop');
            $table->dropColumn('active');
        });
    }
}
