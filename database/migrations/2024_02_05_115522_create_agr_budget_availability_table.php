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
        Schema::create('agr_budget_availability', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('res_minsal_number');
            $table->date('res_minsal_date');
            $table->foreignId('program_id')->constrained('agr_programs');
            $table->foreignId('referrer_id')->nullable()->constrained('users');
            $table->foreignId('document_id')->nullable()->constrained('documents');
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
        Schema::dropIfExists('agr_budget_availability');
    }
};
