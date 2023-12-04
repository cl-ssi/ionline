<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->boolean('all_receptions')->after('confirmation_send_at')->nullable()->default(false);
        });

        //actualizo este nuevo campo de all_receptions
        DB::table('fin_dtes')->where('confirmation_status', true)->update(['all_receptions' => true]);

        // Actualizo el valor de rejected a true cuando es false el confirmation status
        DB::table('fin_dtes')->where('confirmation_status', false)->update(['rejected' => true]);

        
        DB::table('fin_dtes')->update(['reason_rejection' => DB::raw('confirmation_observation')]);

        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->dropColumn('confirmation_observation');
            $table->renameColumn('confirmation_user_id', 'all_receptions_user_id');
            $table->renameColumn('confirmation_ou_id', 'all_receptions_ou_id');
            $table->renameColumn('confirmation_at', 'all_receptions_at');
        });



        DB::table('fin_dtes')->whereNotNull('fin_status')->update(['fin_status' => 1]);
        
        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->renameColumn('fin_status', 'payment_ready');
        });

        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->boolean('payment_ready')->change();
        });


        Schema::table('fin_purchase_orders', function (Blueprint $table) {
        DB::table('fin_purchase_orders')->where('code', 'like', '621%')->update(['cenabast' => true]);
        });


        //se elimina la columna cenabast despues de haber puesto en true en la orden de compra
        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->dropColumn('cenabast');
        
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
            $table->string('confirmation_observation')->after('fecha')->nullable();

        });

        DB::table('fin_dtes')->where('all_receptions', true)->update(['confirmation_observation' => true]);
        DB::table('fin_dtes')->where('rejected', true)->update(['confirmation_observation' => false]);



        Schema::table('fin_dtes', function (Blueprint $table) {
                DB::table('fin_dtes')->update([
                    'confirmation_observation' => DB::raw('reason_rejection'),
                ]);    
            $table->renameColumn('all_receptions_user_id', 'confirmation_user_id');
            $table->renameColumn('all_receptions_ou_id', 'confirmation_ou_id');
            $table->renameColumn('all_receptions_at', 'confirmation_at');
            $table->dropColumn('all_receptions');

            
            $table->string('payment_ready')->change();
            $table->renameColumn('payment_ready', 'fin_status');
        });



        Schema::table('fin_purchase_orders', function (Blueprint $table) {
            DB::table('fin_purchase_orders')->where('code', 'like', '621%')->update(['cenabast' => false]);
        });



        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->boolean('cenabast')->after('establishment_id')->nullable();

        });




    }
    
};
