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
        Schema::create('fin_reception_items', function (Blueprint $table) {
            $table->id();

            $table->string('CodigoCategoria');
            $table->string('Producto');
            $table->string('Cantidad');
            $table->string('Unidad');
            $table->string('EspecificacionComprador');
            $table->string('EspecificacionProveedor');
            $table->string('PrecioNeto');
            $table->string('TotalDescuentos');
            $table->string('TotalCargos');
            $table->string('Total');

            $table->foreign('reception_id')->references('id')->on('fin_receptions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_reception_items');
    }
};
