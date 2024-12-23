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
        Schema::create('doc_numerations', function (Blueprint $table) {
            $table->id();
            $table->boolean('automatic')->default(true);
            $table->unsignedInteger('number')->nullable(); // Correlatives
            $table->string('internal_number')->nullable();
            $table->datetime('date')->nullable();
            $table->foreignId('numerator_id')->nullable()->constrained('users');

            $table->foreignId('doc_type_id')->nullable()->constrained('doc_types');

            $table->string('verification_code')->nullable();
            $table->string('file_path')->nullable();

            $table->string('subject')->nullable();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('establishment_id')->constrained('establishments');

            // Parte de morph para las relaciones
            $table->string('numerable_type')->nullable();
            $table->unsignedBigInteger('numerable_id')->nullable();

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
        Schema::dropIfExists('doc_numerations');
    }
};
