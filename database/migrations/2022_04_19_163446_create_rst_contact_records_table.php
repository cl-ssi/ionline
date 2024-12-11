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
        Schema::create('rst_contact_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('replacement_staff_id');
            $table->foreignId('contact_record_user_id')->nullable();
            $table->string('type');
            $table->dateTime('contact_date', $precision = 0);
            $table->longText('observation');

            $table->foreign('replacement_staff_id')->references('id')->on('rst_replacement_staff');
            $table->foreign('contact_record_user_id')->references('id')->on('users');

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
        Schema::dropIfExists('rst_contact_records');
    }
};
