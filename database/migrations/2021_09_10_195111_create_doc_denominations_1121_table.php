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
        Schema::create('doc_denominations_1121', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->integer('pavilion')->nullable();
            $table->string('denomination')->nullable();
            $table->integer('eq')->nullable();

            $table->integer('anest_level1_value')->nullable();
            $table->integer('anest_level1_aport')->nullable();
            $table->integer('anest_level2_value')->nullable();
            $table->integer('anest_level2_aport')->nullable();
            $table->integer('anest_level3_value')->nullable();
            $table->integer('anest_level3_aport')->nullable();

            $table->integer('surgical_level1_value')->nullable();
            $table->integer('surgical_level1_aport')->nullable();
            $table->integer('surgical_level2_value')->nullable();
            $table->integer('surgical_level2_aport')->nullable();
            $table->integer('surgical_level3_value')->nullable();
            $table->integer('surgical_level3_aport')->nullable();

            $table->integer('procedure_level1_value')->nullable();
            $table->integer('procedure_level1_aport')->nullable();
            $table->integer('procedure_level2_value')->nullable();
            $table->integer('procedure_level2_aport')->nullable();
            $table->integer('procedure_level3_value')->nullable();
            $table->integer('procedure_level3_aport')->nullable();

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
        Schema::dropIfExists('doc_denominations_1121');
    }
};
