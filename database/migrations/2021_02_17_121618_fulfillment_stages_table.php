<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FulfillmentStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('doc_fulfillments', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('service_request_id');
          $table->integer('year');
          $table->integer('month');
          $table->string('type', 100)->nullable();
          $table->datetime('start_date')->nullable();
          $table->datetime('end_date')->nullable();
          $table->string('observation', 100)->nullable();

          $table->foreign('service_request_id')->references('id')->on('doc_service_requests');
          $table->timestamps();
      });

      Schema::create('doc_fulfillments_absences', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('fulfillment_id');
          $table->string('type', 100)->nullable();
          $table->datetime('start_date')->nullable();
          $table->datetime('end_date')->nullable();
          $table->string('observation', 100)->nullable();

          $table->foreign('fulfillment_id')->references('id')->on('doc_fulfillments');
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
        Schema::dropIfExists('doc_fulfillments_absences');
        Schema::dropIfExists('doc_fulfillments');
    }
}
