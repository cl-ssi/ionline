<?php

use App\Models\Finance\AccountingCode;
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
        Schema::create('fin_accounting_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->primary();
            $table->string('description');
            $table->timestamps();
        });

        /** Esto no debería estar acá, estoy esperando las cuentas contables */
        AccountingCode::create([
            'id'          => 5320413,
            'description' => 'Equipos Menores',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_accounting_codes');
    }
};
