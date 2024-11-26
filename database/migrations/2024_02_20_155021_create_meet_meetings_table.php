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
        Schema::create('meet_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedinteger('correlative')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('user_creator_id')->nullable()->constrained('users');
            $table->foreignId('user_responsible_id')->nullable()->constrained('users');
            $table->foreignId('ou_responsible_id')->nullable()->constrained('organizational_units');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            $table->text('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('mechanism')->nullable();
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
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
        Schema::dropIfExists('meet_meetings');
    }
};
