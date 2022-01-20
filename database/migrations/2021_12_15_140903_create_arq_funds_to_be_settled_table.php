<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqFundsToBeSettledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_funds_to_be_settled', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date', $precision = 0);
            $table->float('amount', 15, 2);
            $table->foreignId('document_id')->constrained('documents');
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
        Schema::dropIfExists('arq_funds_to_be_settled');
    }
}
