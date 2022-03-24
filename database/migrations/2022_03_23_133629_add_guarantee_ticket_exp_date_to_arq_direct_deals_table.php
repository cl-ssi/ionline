<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuaranteeTicketExpDateToArqDirectDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_direct_deals', function (Blueprint $table) {
            $table->date('guarantee_ticket_exp_date')->nullable()->after('guarantee_ticket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_direct_deals', function (Blueprint $table) {
            $table->dropColumn('guarantee_ticket_exp_date');
        });
    }
}
