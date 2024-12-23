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
        Schema::create('arq_event_request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_form_id')->constrained('arq_request_forms');
            $table->foreignId('signer_user_id')->nullable()->constrained('users');
            $table->foreignId('ou_signer_user')->nullable()->constrained('organizational_units');
            $table->string('position_signer_user')->nullable();
            $table->unsignedInteger('cardinal_number')->nullable();
            $table->enum('status', ['approved', 'rejected', 'pending']);
            $table->string('event_type')->nullable();
            $table->longText('comment')->nullable();
            $table->foreignId('purchaser_id')->nullable()->constrained('users');
            $table->float('purchaser_amount', 15, 2)->nullable();
            $table->text('purchaser_observation')->nullable();
            $table->dateTime('signature_date', $precision = 0)->nullable();
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
};
