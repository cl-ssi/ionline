<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolsConvenioMarcoToArqImmediatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_immediate_purchases', function (Blueprint $table) {
            $table->string('resol_supplementary_agree')->nullable()->after('description');
            $table->string('resol_awarding')->nullable()->after('resol_supplementary_agree');
            $table->string('resol_purchase_intention')->nullable()->after('resol_awarding');
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
            $table->dropColumn(['resol_supplementary_agree', 'resol_awarding', 'resol_purchase_intention']);
        });
    }
}
