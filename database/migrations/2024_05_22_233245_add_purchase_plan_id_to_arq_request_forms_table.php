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
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->foreignId('purchase_plan_id')->nullable()->after('folio')->constrained('ppl_purchase_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->dropForeign(['purchase_plan_id']);
            $table->dropColumn('purchase_plan_id');
        });
    }
};
