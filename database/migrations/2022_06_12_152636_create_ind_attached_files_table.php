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
        Schema::create('ind_attached_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('document_name')->nullable();
            $table->string('commune')->nullable();
            $table->string('establishment')->nullable();
            $table->unsignedTinyInteger('section')->nullable();
            $table->morphs('attachable');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::dropIfExists('ind_values_attached_files');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ind_attached_files');
        Schema::create('ind_values_attached_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('document_name')->nullable();
            $table->foreignId('value_id')->constrained('ind_values');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
