<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Doc1121Fulfillments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_1121_fulfillments', function (Blueprint $table) {
          $table->foreignId('doc_1121_id')->unsigned();
          $table->foreign('doc_1121_id')->references('id')->on('doc_denominations_1121')->onDelete('cascade');

          $table->foreignId('doc_fulfillments_id')->unsigned();
          $table->foreign('doc_fulfillments_id')->references('id')->on('doc_fulfillments')->onDelete('cascade');
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
        Schema::dropIfExists('doc_1121_fulfillments');
    }
}
