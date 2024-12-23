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
        Schema::create('agr_quotas', function (Blueprint $table) {
            $table->id();
            $table->string('description', 32)->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('amount')->nullable();
            $table->date('transfer_at')->nullable();
            $table->integer('voucher_number')->nullable();
            $table->foreignId('process_id')->constrained('agr_processes');
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
        Schema::dropIfExists('agr_quotas');
    }
};
