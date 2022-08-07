<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsApiToArqPurchasingProcessDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->string('supplier_run')->nullable()->after('user_id');
            $table->text('supplier_name')->nullable()->after('supplier_run');
            $table->text('supplier_specifications')->nullable()->after('supplier_name');
            $table->float('charges', 15, 2)->nullable()->after('tax');
            $table->float('discounts', 15, 2)->nullable()->after('charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_purchasing_process_detail', function (Blueprint $table) {
            $table->dropColumn(['supplier_run', 'supplier_name', 'supplier_specifications', 'charges', 'discounts']);
        });
    }
}
