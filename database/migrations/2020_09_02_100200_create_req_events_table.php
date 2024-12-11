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
        Schema::create('req_events', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->enum('status', ['creado', 'respondido', 'cerrado', 'derivado', 'reabierto', 'en copia']);
            $table->datetime('limit_at')->nullable();
            $table->foreignId('from_user_id')->constrained('users');
            $table->foreignId('from_ou_id')->constrained('organizational_units')->default(69);
            $table->foreignId('to_user_id')->constrained('users');
            $table->foreignId('to_ou_id')->constrained('organizational_units');
            $table->foreignId('requirement_id')->constrained('req_requirements');
            $table->boolean('to_authority')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('req_documents_events', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('req_events')->onDelete('cascade');
            $table->foreignId('document_id')->constrained('req_events')->onDelete('cascade');
            $table->timestamps();
        });

        /*Schema::create('req_events_files', function (Blueprint $table) {
            $table->integer('event_id')->unsigned();
            $table->integer('file_id')->unsigned();

            $table->foreign('event_id')->references('id')->on('req_events')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('req_files')->onDelete('cascade');

            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('req_documents_events');
        Schema::dropIfExists('req_events');
    }
};
