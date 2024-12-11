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
        Schema::create('sum_event_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('before_event_id')->constrained('sum_event_types');
            $table->boolean('before_sub_event')->default(false);
            $table->foreignId('after_event_id')->constrained('sum_event_types');
            $table->boolean('after_sub_event')->default(false);
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
        Schema::dropIfExists('sum_event_links');
    }
};
