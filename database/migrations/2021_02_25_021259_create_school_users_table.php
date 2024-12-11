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
        Schema::create('school_users_external', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->foreignId('user_external_id')->constrained('users_external');
            $table->boolean('admin')->nullable();
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
        Schema::dropIfExists('school_users_external');
    }
};
