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
        Schema::create('arq_passengers', function (Blueprint $table) {
            $table->id();
            $table->string('passenger_type')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('run')->nullable();
            $table->char('dv', 1)->nullable();
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family')->nullable();
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
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->foreignId('budget_item_id')->nullable()->constrained('cfg_budget_items');
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
};
