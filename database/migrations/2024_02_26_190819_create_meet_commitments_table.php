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
        Schema::create('meet_commitments', function (Blueprint $table) {
            $table->id();

            $table->text('description')->nullable();
            $table->string('priority')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('commitment_user_id')->nullable()->constrained('users');
            $table->foreignId('commitment_ou_id')->nullable()->constrained('organizational_units');
            $table->date('closing_date')->nullable();
            $table->foreignId('meeting_id')->nullable()->constrained('meet_meetings');
            $table->foreignId('requirement_id')->nullable()->constrained('req_requirements');
            $table->foreignId('user_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('meet_commitments');
    }
};
