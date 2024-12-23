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
        Schema::create('arq_event_request_form_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('name');
            $table->string('extension');
            $table->foreignId('event_request_form_id')->constrained('arq_event_request_forms');
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
        Schema::dropIfExists('arq_event_request_form_files');
    }
};
