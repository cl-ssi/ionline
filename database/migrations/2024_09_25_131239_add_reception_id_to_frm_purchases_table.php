<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceptionIdToFrmPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frm_purchases', function (Blueprint $table) {
            // Agrega la columna reception_id que referencia a la tabla fin_receptions
            $table->unsignedBigInteger('reception_id')->nullable()->after('user_id');

            // Define la clave foránea hacia la tabla fin_receptions
            $table->foreign('reception_id')->references('id')->on('fin_receptions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frm_purchases', function (Blueprint $table) {
            // Elimina la clave foránea y la columna reception_id
            $table->dropForeign(['reception_id']);
            $table->dropColumn('reception_id');
        });
    }
}
