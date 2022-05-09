<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToArqItemRequestForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_item_request_forms', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->after('budget_item_id')
                ->constrained('unspsc_products');

            $table->string('article', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_item_request_forms', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id']);
        });
    }
}
