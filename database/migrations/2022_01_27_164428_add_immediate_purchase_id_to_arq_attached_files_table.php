<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImmediatePurchaseIdToArqAttachedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_attached_files', function (Blueprint $table) {
            $table->foreignId('immediate_purchase_id')->nullable()->after('tender_id')->constrained('arq_immediate_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_attached_files', function (Blueprint $table) {
            $table->dropForeign(['immediate_purchase_id']);
            $table->dropColumn('immediate_purchase_id');
        });
    }
}
