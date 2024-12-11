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
        Schema::create('arq_passengers_changed', function (Blueprint $table) {
            $table->id();
            $table->string('passenger_type')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('run')->nullable();
            $table->char('dv', 1)->nullable();
            $table->string('name')->nullable();
            $table->string('fathers_family')->nullable();
            $table->string('mothers_family')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('round_trip')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->string('baggage')->nullable();
            $table->float('unit_value', 15, 2)->nullable();
            $table->string('status');
            $table->foreignId('passenger_id')->nullable()->constrained('arq_passengers');
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
        Schema::dropIfExists('arq_passengers_changed');
    }
};
