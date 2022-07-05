<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrmDispatchVerificationMailingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_dispatch_verification_mailings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispatch_id');
            $table->string('status'); //pendiente, recibido conforme, recibido no conforme
            
            $table->string('sender_observation')->nullable(); //pendiente, recibido conforme, recibido no conforme
            $table->dateTime('delivery_date'); //fecha de envío
            
            $table->string('receiver_observation')->nullable();
            $table->dateTime('confirmation_date')->nullable(); //fecha vencimiento
            

            $table->foreign('dispatch_id')->references('id')->on('frm_dispatches')->onDelete('cascade');
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
        Schema::dropIfExists('frm_dispatch_verification_mailings');
    }
}
