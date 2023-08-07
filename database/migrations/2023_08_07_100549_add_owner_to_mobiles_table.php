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
        Schema::table('res_mobiles', function (Blueprint $table) {
            $table->boolean('directory')->after('user_id')->default(false);
            $table->boolean('owner')->after('user_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('res_mobiles', function (Blueprint $table) {
            $table->dropColumn('owner');
        });
    }
};
