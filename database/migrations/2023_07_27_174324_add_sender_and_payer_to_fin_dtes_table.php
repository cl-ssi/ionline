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
        Schema::table('fin_dtes', function (Blueprint $table) {
            //Datos envia a pago
            $table->foreignId('sender_id')->after('fin_folio_tesoreria')->nullable()->constrained('users');
            $table->foreignId('sender_ou')->after('sender_id')->nullable()->constrained('organizational_units');
            $table->datetime('sender_at')->after('sender_ou')->nullable();

            //Datos pagador
            $table->foreignId('payer_id')->after('sender_at')->nullable()->constrained('users');
            $table->foreignId('payer_ou')->after('payer_id')->nullable()->constrained('organizational_units');
            $table->datetime('payer_at')->after('payer_ou')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            //
            $table->dropForeign(['sender_id']);
            $table->dropColumn('sender_id');

            $table->dropForeign(['sender_ou']);
            $table->dropColumn('sender_ou');

            $table->dropColumn('sender_at');


            $table->dropForeign(['payer_id']);
            $table->dropColumn('payer_id');

            $table->dropForeign(['payer_ou']);
            $table->dropColumn('payer_ou');

            $table->dropColumn('payer_at');
        });
    }
};
