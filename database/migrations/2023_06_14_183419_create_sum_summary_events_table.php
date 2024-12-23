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
        Schema::create('sum_summary_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_type_id')->nullable()->constrained('sum_event_types');
            $table->text('body')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('summary_id')->nullable()->constrained('sum_summaries');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            // $table->foreignId('father_event_id')->nullable()->constrained('sum_summary_events');
            $table->timestamps();
            $table->softDeletes();
        });

        // esta columna a la misma tabla
        Schema::table('sum_summary_events', function (Blueprint $table) {
            $table->foreignId('father_event_id')->after('creator_id')->nullable()->constrained('sum_summary_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sum_summary_events');
    }
};
