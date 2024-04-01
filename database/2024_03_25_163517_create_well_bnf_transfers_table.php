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
        Schema::create('well_bnf_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('well_bnf_requests');
            
            $table->integer('installment_number');

            $table->datetime('payed_date')->nullable();
            $table->foreignId('payed_responsable_id')->nullable()->constrained('users');
            $table->float('payed_amount', 14, 2)->nullable();

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
        Schema::dropIfExists('well_bnf_transfers');
    }
};
