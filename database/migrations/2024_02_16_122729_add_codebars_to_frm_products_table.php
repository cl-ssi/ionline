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
        Schema::table('frm_products', function (Blueprint $table) {
            $table->string('barcode')->nullable()->change();
            // $table->integer('experto_id')->after('barcode')->nullable();
            $table->string('experto_id')->nullable()->change();
            $table->foreignId('unspsc_product_id')->after('experto_id')->nullable()->constrained('unspsc_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_products', function (Blueprint $table) {
            $table->dropColumn('barcode');
            $table->dropColumn('experto_id');
            $table->dropForeign(['frm_products_unspsc_product_id_foreign']);
            $table->dropColumn('unspsc_product_id');
        });
    }
};
