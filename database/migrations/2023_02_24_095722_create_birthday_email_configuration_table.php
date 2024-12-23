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
        Schema::create('rrhh_birthday_email_configuration', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); //asunto
            $table->string('tittle'); //título
            $table->text('message');
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sirh_active_users', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->unique();
            $table->char('dv', 1);
            $table->string('name');
            $table->string('email')->nullable();
            $table->date('birthdate');
            $table->date('start_contract_date')->nullable();
            $table->date('end_contract_date')->nullable();
            $table->string('legal_quality');
            $table->string('ou_description');

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
        Schema::dropIfExists('sirh_active_users');
        Schema::dropIfExists('rrhh_birthday_email_configuration');
    }
};
