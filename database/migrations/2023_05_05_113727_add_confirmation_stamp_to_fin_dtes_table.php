<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmationStampToFinDtesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fin_dtes', function (Blueprint $table) {
            $table->string('confirmation_observation')->after('fecha')->nullable();
            $table->datetime('confirmation_at')->after('fecha')->nullable();
            $table->foreignId('confirmation_ou_id')->after('fecha')->nullable()->constrained('organizational_units');
            $table->foreignId('confirmation_user_id')->after('fecha')->nullable()->constrained('users');
            $table->datetime('confirmation_send_at')->after('fecha')->nullable()->default(null);
            $table->foreignId('confirmation_sender_id')->after('fecha')->nullable()->constrained('users');
            $table->boolean('confirmation_status')->after('fecha')->nullable()->default(null);
            
            $table->index(['folio']);
            $table->index(['folio_oc']);
            $table->index(['emisor']);
            $table->index(['razon_social_emisor']);
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
            $table->dropForeign(['confirmation_user_id']);
            $table->dropForeign(['confirmation_sender_id']);
            $table->dropForeign(['confirmation_ou_id']);

            $table->dropColumn('confirmation_status');
            $table->dropColumn('confirmation_sender_id');
            $table->dropColumn('confirmation_send_at');
            $table->dropColumn('confirmation_user_id');
            $table->dropColumn('confirmation_ou_id');
            $table->dropColumn('confirmation_at');
            $table->dropColumn('confirmation_observation');
        });
    }
}
