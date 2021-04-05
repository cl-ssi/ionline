<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersExternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_external', function (Blueprint $table) {
            $table->id()->unique();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->string('password');
            // $table->boolean('is_super')->default(false);
            // $table->rememberToken();
            // $table->timestamps();
            $table->char('dv',1)->nullable();
            $table->string('name')->nullable();
            $table->string('fathers_family')->nullable();
            $table->string('mothers_family')->nullable();
            $table->string('gender')->nullable();
            $table->string('email');
            $table->string('email_personal')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('position')->nullable();
            $table->date('birthday')->nullable();
            // $table->foreignId('school_id')->nullable();
            // $table->foreign('school_id')->references('id')->on('schools');
            $table->rememberToken();
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
        //Schema::dropForeign(['school_id']);
        //$table->dropForeign(['school_id']);
        Schema::dropIfExists('users_external');
    }
}
