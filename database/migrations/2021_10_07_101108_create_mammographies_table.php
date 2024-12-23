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
        Schema::create('mammographies', function (Blueprint $table) {
            $table->id();
            $table->integer('run');
            $table->char('dv');
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->date('birth_date');
            $table->integer('age');
            $table->string('email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('telephone')->nullable();
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units'); //Confirmar
            $table->string('organizationalUnit')->nullable(); //Confirmar
            $table->boolean('inform_method')->nullable(); //Confirmar
            $table->datetime('arrival_at')->nullable(); //Confirmar
            $table->datetime('exam_date')->nullable(); //Confirmar
            $table->string('ed_observation')->nullable(); //Confirmar

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
        Schema::dropIfExists('mammographies');
    }
};
