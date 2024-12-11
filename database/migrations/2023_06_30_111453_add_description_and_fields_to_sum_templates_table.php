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
        Schema::table('sum_templates', function (Blueprint $table) {
            $table->text('fields')->after('name')->nullable();
            $table->string('description')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sum_templates', function (Blueprint $table) {
            $table->dropColumn('fields');
            $table->dropColumn('description');
        });
    }
};
