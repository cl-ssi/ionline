<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocFulfillmentsAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_fulfillments_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');
            $table->foreignId('fulfillment_id');
            $table->foreign('fulfillment_id')->references('id')->on('doc_fulfillments');
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
        Schema::dropIfExists('doc_fulfillments_attachments');
    }
}
