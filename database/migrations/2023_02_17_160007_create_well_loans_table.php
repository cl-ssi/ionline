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
        Schema::create('well_loans', function (Blueprint $table) {
            $table->id();
            $table->integer('folio')->nullable();
            $table->string('rut')->nullable();
            $table->string('names')->nullable();
            $table->date('date')->nullable();
            $table->integer('number')->nullable();
            $table->integer('late_number')->nullable();
            $table->float('late_interest')->nullable();
            $table->float('late_amortization')->nullable();
            $table->float('late_value')->nullable();
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
        Schema::dropIfExists('well_loans');
    }
};
