<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item');//articulo
            $table->unsignedBigInteger('quantity');//cantidad
            $table->longText('specification');//especificaciones tecnicas.
            $table->unsignedBigInteger('item_estimated_expense')->nullable();//Gasto Estimado.
            $table->unsignedBigInteger('expense')->nullable();//Gasto Estimado.
            $table->unsignedInteger('request_form_id')->unsigned()->nullable();//id del formulario de requerimiento.
            $table->unsignedInteger('request_form_item_codes_id')->unsigned()->nullable();//id del item presupuestario.

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_items');
    }
}
