<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_quotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description',32)->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('amount')->nullable();
            $table->date('transfer_at')->nullable();
            $table->integer('voucher_number')->nullable();
            $table->bigInteger('agreement_id')->unsigned();
            $table->timestamps();

            $table->foreign('agreement_id')->references('id')->on('agr_agreements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_quotas');
    }
}
