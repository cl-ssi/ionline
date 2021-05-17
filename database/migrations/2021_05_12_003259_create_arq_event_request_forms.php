<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqEventRequestForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_event_request_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('signer_user_id')->nullable();
            $table->foreignId('request_form_id');
            $table->integer('ou_signer_user');
            $table->string('position_signer_user');
            $table->unsignedInteger('cardinal_number')->nullable();
            $table->enum('status', ['approved', 'rejected', 'created']);
            $table->longText('comment')->nullable();
            $table->dateTime('signature_date', $precision = 0)->nullable();
            $table->string('event_type');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('signer_user_id')->references('id')->on('users');
            $table->foreign('request_form_id')->references('id')->on('arq_request_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_event_request_forms');
    }
}
