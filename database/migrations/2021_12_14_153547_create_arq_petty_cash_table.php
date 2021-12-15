<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqPettyCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_petty_cash', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date', $precision = 0);
            $table->integer('amount');
            $table->integer('receipt_number');
            $table->string('receipt_type');
            $table->string('file')->nullable();
            $table->foreignId('user_id')->constrained('users'); //Usuario que registró el fondo menor.
            $table->foreignId('purchasing_process_id')->constrained('arq_purchasing_processes');
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
        Schema::dropIfExists('arq_petty_cash');
    }
}
