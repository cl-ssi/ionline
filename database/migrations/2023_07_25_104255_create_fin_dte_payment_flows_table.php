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
        Schema::create('fin_dte_payment_flows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');
            $table->string('status')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_dte_payment_flows');
    }
};
