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
        Schema::create('drg_substances', function (Blueprint $table) {
            $table->id('id');
            $table->boolean('presumed')->default(1);
            $table->string('name');
            $table->enum('rama', ['Alucinógenos', 'Estimulantes', 'Depresores', 'Precursores'])->nullable();
            $table->enum('unit', ['Ampollas', 'Mililitros', 'Gramos', 'Unidades'])->nullable();
            $table->enum('laboratory', ['SEREMI', 'ISP'])->nullable()->default(null);
            $table->boolean('isp')->nullable()->default(0);
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
        Schema::dropIfExists('drg_substances');
    }
};
