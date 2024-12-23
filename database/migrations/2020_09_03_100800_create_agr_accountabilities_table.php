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
        Schema::create('agr_accountabilities', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->integer('document');
            $table->date('date');
            $table->unsignedBigInteger('agreement_id');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('agr_accountabilities');
    }
};
