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
        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->foreignId('receiver_id')->nullable()->after('user_id')->constrained('users');
            $table->unsignedBigInteger('establishment_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->dropForeign(['receiver_id']);
            $table->dropColumn('receiver_id');
        });
    }
};
