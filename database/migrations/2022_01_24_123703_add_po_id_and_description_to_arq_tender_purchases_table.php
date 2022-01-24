<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoIdAndDescriptionToArqTenderPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tender_purchases', function (Blueprint $table) {
            $table->string('po_id')->nullable()->after('id');
            $table->text('description')->nullable()->after('estimated_delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_tender_purchases', function (Blueprint $table) {
            $table->dropColumn(['po_id', 'description']);
        });
    }
}
