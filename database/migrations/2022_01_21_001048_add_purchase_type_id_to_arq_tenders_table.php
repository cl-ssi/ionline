<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseTypeIdToArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->dropColumn('tender_type');
            $table->foreignId('purchase_type_id')->after('id')->default(13)->constrained('cfg_purchase_types'); //licitacion LE por defecto
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->string('tender_type');
            $table->dropForeign(['purchase_type_id']);
            $table->dropColumn('purchase_type_id');
        });
    }
}
