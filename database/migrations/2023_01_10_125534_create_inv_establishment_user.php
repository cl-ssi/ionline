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
        Schema::create('inv_establishment_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('role_id')->nullable()->constrained('roles');
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
        Schema::dropIfExists('inv_establishment_user');
    }
};
