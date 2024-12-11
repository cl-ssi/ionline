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
        Schema::create('req_events_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('req_events')->onDelete('cascade');
            $table->foreignId('requirement_id')->nullable()->constrained('req_requirements');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['not viewed', 'viewed']);
            //$table->integer('category_id')->unsigned();
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
        Schema::dropIfExists('req_events_status');
    }
};
