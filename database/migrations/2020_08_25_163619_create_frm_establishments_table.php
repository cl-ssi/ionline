<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_establishments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            //se añade por defecto 1 para la relación con la bodega
            $table->unsignedBigInteger('pharmacy_id')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pharmacy_id')->references('id')->on('frm_pharmacies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_establishments');
    }
}
