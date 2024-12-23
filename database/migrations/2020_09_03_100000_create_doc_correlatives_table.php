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
        Schema::create('doc_correlatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->nullable()->constrained('doc_types');
            $table->integer('correlative');
            $table->foreignId('establishment_id')->default(38)->constrained('establishments');
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
        Schema::dropIfExists('doc_correlatives');
    }
};
