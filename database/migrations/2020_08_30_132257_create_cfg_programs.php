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
        Schema::create('cfg_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('alias', 50)->nullable();
            $table->string('alias_finance', 255)->nullable();
            $table->string('financial_type', 50)->nullable();
            $table->unsignedSmallInteger('folio')->nullable();
            $table->foreignId('subtitle_id')->constrained('cfg_subtitles');
            $table->bigInteger('budget');
            $table->unsignedSmallInteger('period');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('is_program')->nullable();
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
            $table->unsignedInteger('ministerial_resolution_number')->nullable();
            $table->date('ministerial_resolution_date')->nullable();
            $table->unsignedInteger('resource_distribution_number')->nullable();
            $table->date('resource_distribution_date')->nullable();
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
        Schema::dropIfExists('cfg_programs');
    }
};
