<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_passengers', function (Blueprint $table) {
            $table->id();

            $table->string('passenger_type')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('run');
            $table->char('dv',1);
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->date('birthday');
            $table->string('phone_number');
            $table->string('email');
            $table->string('round_trip');
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('departure_date');
            $table->dateTime('return_date')->nullable();
            $table->string('baggage');
            $table->float('unit_value', 15, 2);
            $table->foreignId('request_form_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('request_form_id')->references('id')->on('arq_request_forms');

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
        Schema::dropIfExists('arq_passengers');
    }
}
