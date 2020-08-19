<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrgSubstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drg_substances', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('presumed')->default(1);
            $table->string('name');
            $table->enum('rama',['Alucinógenos','Estimulantes', 'Depresores'])->nullable();
            $table->enum('unit', ['Ampollas', 'Mililitros', 'Gramos', 'Unidades'])->nullable();
            $table->enum('laboratory',['SEREMI', 'ISP'])->nullable()->default(NULL);
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
}
