<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lobby_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsible_id')->constrained('users');
            $table->string('petitioner');
            $table->date('date');
            $table->datetime('start_at')->nullable();
            $table->datetime('end_at')->nullable();
            $table->string('mecanism');
            $table->text('subject');
            $table->text('exponents')->nullable();
            $table->text('details')->nullable();
            $table->boolean('status')->default(0);
            $table->string('request_file')->nullable();
            $table->string('acta_file')->nullable();
            $table->foreignId('signature_id')->nullable()->constrained('doc_signatures');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lobby_meeting_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('lobby_meetings');
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('lobby_meeting_user');
        Schema::dropIfExists('lobby_meetings');
    }
}
