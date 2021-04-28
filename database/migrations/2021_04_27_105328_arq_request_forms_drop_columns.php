<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArqRequestFormsDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->dropColumn(['admin_id', 'whorequest_id', 'whorequest_unit_id', 'whorequest_position', 'whoauthorize_id',
                                'whoauthorize_unit_id', 'whoauthorize_position', 'finance_id', 'finance_unit_id', 'finance_position',
                                'supplying_id', 'supplying_unit_id', 'supplying_position', 'derive_supplying_id', ]);

            $table->renameColumn('user_id', 'creator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
