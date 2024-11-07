<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_dispatches', function (Blueprint $table) {

          $table->id();
          $table->dateTime('date'); //fecha xfecha
          $table->unsignedBigInteger('pharmacy_id'); //origen
          $table->unsignedBigInteger('establishment_id')->nullable();
          $table->longText('notes')->nullable(); //notas
          $table->unsignedBigInteger('user_id');
          $table->boolean('sendC19')->default(0);

          $table->timestamps();
          $table->softDeletes();

          
          $table->foreignId('pharmacy_id')->nullable()->constrained('frm_pharmacies')
          
          $table->foreignId('establishment_id')->nullable()->constrained('frm_establishments');

          $table->foreignId('user_id')->nullable()->constrained('users');

          $table->foreignId('receiver_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_dispatches');
    }
}
