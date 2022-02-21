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
            $table->foreignId('request_form_id');
            $table->foreignId('signer_user_id')->nullable();
            $table->foreignId('ou_signer_user')->nullable();
            $table->string('position_signer_user')->nullable();
            $table->unsignedInteger('cardinal_number')->nullable();
            $table->enum('status', ['approved', 'rejected', 'pending']);
            $table->string('event_type')->nullable();
            $table->longText('comment')->nullable();
            $table->foreignId('purchaser_id')->nullable()->constrained('users');
            $table->float('purchaser_amount', 15, 2)->nullable();
            $table->dateTime('signature_date', $precision = 0)->nullable();
            $table->foreign('signer_user_id')->references('id')->on('users');
            $table->foreign('ou_signer_user')->references('id')->on('organizational_units');
            $table->foreign('request_form_id')->references('id')->on('arq_request_forms');
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
        Schema::dropIfExists('arq_event_request_forms');
    }
}
