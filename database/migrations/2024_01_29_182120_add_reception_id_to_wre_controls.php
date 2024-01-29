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
        Schema::table('wre_controls', function (Blueprint $table) {
            $table->foreignId('reception_id')->nullable()->after('visation_warehouse_manager_status')->constrained('fin_receptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wre_controls', function (Blueprint $table) {            
            $table->dropForeign(['reception_id']);
            $table->dropColumn('reception_id');
        });
    }
};
