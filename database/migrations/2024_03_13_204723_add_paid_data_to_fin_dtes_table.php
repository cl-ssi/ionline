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
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->boolean('paid')->nullable()->after('observation');
            $table->integer('paid_folio')->nullable()->after('paid');
            $table->date('paid_at')->nullable()->after('paid_folio');
            $table->integer('paid_effective_amount')->nullable()->after('paid_at');
            $table->boolean('paid_automatic')->nullable()->after('paid_effective_amount');
            $table->boolean('paid_manual')->nullable()->after('paid_automatic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->dropColumn('paid');
            $table->dropColumn('paid_folio');
            $table->dropColumn('paid_at');
            $table->dropColumn('paid_effective_amount');
            $table->dropColumn('paid_automatic');
            $table->dropColumn('paid_manual');
        });
    }
};
