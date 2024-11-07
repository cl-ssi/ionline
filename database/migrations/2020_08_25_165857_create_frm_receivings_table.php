<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_receivings', function (Blueprint $table) {

            $table->id();
            $table->dateTime('date'); //fecha xfecha
            $table->unsignedBigInteger('establishment_id'); //origen
            $table->unsignedBigInteger('pharmacy_id'); //destino
            $table->longText('notes')->nullable(); //notas
            $table->text('order_number')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('establishment_id')->nullable()->constrained('frm_establishments');
           
            $table->foreignId('pharmacy_id')->nullable()->constrained('frm_pharmacies');

            $table->foreignId('user_id')->nullable()->constrained('users')

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_receivings');
    }
}
