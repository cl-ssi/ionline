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
        Schema::create('prof_agenda_external_users', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->unique();
            $table->char('dv', 1);
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->string('gender')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('prof_agenda_external_users');
    }
};
