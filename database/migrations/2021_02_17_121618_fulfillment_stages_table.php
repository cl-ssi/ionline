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
          $table->integer('year')->nullable();
          $table->integer('month')->nullable();
          $table->string('type', 100)->nullable();
          $table->datetime('start_date')->nullable();
          $table->datetime('end_date')->nullable();
          $table->string('observation', 100)->nullable();

          $table->boolean('responsable_approbation')->default(0);
          $table->unsignedBigInteger('responsable_approver_id');
          $table->boolean('rrhh_approbation')->default(0);
          $table->unsignedBigInteger('rrhh_approver_id')->nullable();
          $table->boolean('finances_approbation')->default(0);
          $table->unsignedBigInteger('finances_approver_id')->nullable();

          $table->foreign('service_request_id')->references('id')->on('doc_service_requests');
          $table->foreign('responsable_approver_id')->references('id')->on('users');
          $table->foreign('rrhh_approver_id')->references('id')->on('users');
          $table->foreign('finances_approver_id')->references('id')->on('users');
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('doc_fulfillments_items', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('fulfillment_id');
          $table->string('type', 100)->nullable();
          $table->datetime('start_date')->nullable();
          $table->datetime('end_date')->nullable();
          $table->string('observation', 100)->nullable();

          $table->boolean('responsable_approbation')->default(0);
          $table->unsignedBigInteger('responsable_approver_id');
          $table->boolean('rrhh_approbation')->default(0);
          $table->unsignedBigInteger('rrhh_approver_id')->nullable();
          $table->boolean('finances_approbation')->default(0);
          $table->unsignedBigInteger('finances_approver_id')->nullable();

          $table->foreign('fulfillment_id')->references('id')->on('doc_fulfillments');
          $table->foreign('responsable_approver_id')->references('id')->on('users');
          $table->foreign('rrhh_approver_id')->references('id')->on('users');
          $table->foreign('finances_approver_id')->references('id')->on('users');

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
        Schema::dropIfExists('doc_fulfillments_items');
        Schema::dropIfExists('doc_fulfillments');
    }
}
