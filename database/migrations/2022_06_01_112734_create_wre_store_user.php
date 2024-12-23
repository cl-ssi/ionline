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
        Schema::create('wre_store_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('role_id')->nullable()->constrained('roles');
            $table->boolean('status')->nullable();
            $table->boolean('is_visator')->default(false);
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
        Schema::dropIfExists('wre_store_user');
    }
};
