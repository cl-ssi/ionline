<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysAndTypeDeliveriesToArqImmediatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->string('days_type_delivery')->nullable()->after('estimated_delivery_date');
            $table->integer('days_delivery')->nullable()->after('days_type_delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->dropColumn(['days_type_delivery', 'days_delivery']);
        });
    }
}
