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
        Schema::table('well_bnf_subsidies', function (Blueprint $table) {
            $table->dropForeign(['benefit_id']);
            $table->foreign('benefit_id')->references('id')->on('well_bnf_benefits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('well_bnf_subsidies', function (Blueprint $table) {
            $table->dropForeign(['benefit_id']);
            $table->foreign('benefit_id')->references('id')->on('well_bnf_benefits');
        });
    }
};
