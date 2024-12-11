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
        Schema::create('doc_denominations_formula', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->integer('pavilion')->nullable();
            $table->string('denomination')->nullable();
            $table->integer('eq')->nullable();

            $table->integer('surgical1_level1')->nullable();
            $table->integer('surgical1_level2')->nullable();
            $table->integer('surgical1_level3')->nullable();

            $table->integer('surgical2_level1')->nullable();
            $table->integer('surgical2_level2')->nullable();
            $table->integer('surgical2_level3')->nullable();

            $table->integer('surgical3_level1')->nullable();
            $table->integer('surgical3_level2')->nullable();
            $table->integer('surgical3_level3')->nullable();

            $table->integer('surgical4_level1')->nullable();
            $table->integer('surgical4_level2')->nullable();
            $table->integer('surgical4_level3')->nullable();

            $table->integer('anest1_level1')->nullable();
            $table->integer('anest1_level2')->nullable();
            $table->integer('anest1_level3')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('doc_denominations_formula');
    }
};
