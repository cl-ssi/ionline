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
        Schema::create('res_telephones', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->integer('minsal')->unique();
            $table->macAddress('mac')->unique()->nullable();
            $table->foreignId('place_id')->nullable()->constrained('cfg_places');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('res_telephone_user', function (Blueprint $table) {
            $table->foreignId('telephone_id')->constrained('res_telephones');
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
        Schema::dropIfExists('res_telephones');
    }
};
