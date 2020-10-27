<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqPassagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_passages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('run')->unsigned()->unique();
            $table->char('dv',1);
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->date('birthday')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('tramo')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->dateTime('from_date')->nullable();
            $table->string('baggage')->nullable();
            $table->unsignedBigInteger('item_estimated_expense')->nullable();//Gasto Estimado.
            $table->unsignedBigInteger('expense')->nullable();//Gasto Estimado.
            $table->unsignedInteger('request_form_item_codes_id')->unsigned()->nullable();//id del item presupuestario
            $table->unsignedInteger('request_form_id')->unsigned()->nullable();//id del formulario de requerimiento.

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
        Schema::dropIfExists('arq_passages');
    }
}
