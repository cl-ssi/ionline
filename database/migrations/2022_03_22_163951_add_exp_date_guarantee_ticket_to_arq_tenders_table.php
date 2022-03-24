<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpDateGuaranteeTicketToArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->date('guarantee_ticket_exp_date')->nullable()->after('guarantee_ticket');
            $table->string('memo_number')->nullable()->after('guarantee_ticket_exp_date'); //N° de oficio
            $table->date('taking_of_reason_date')->nullable()->after('has_taking_of_reason');
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
            $table->dropColumn(['guarantee_ticket_exp_date','memo_number', 'taking_of_reason_date']);
        });
    }
}
