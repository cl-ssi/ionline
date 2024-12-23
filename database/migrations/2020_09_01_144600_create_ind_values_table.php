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
        Schema::create('ind_values', function (Blueprint $table) {
            $table->id();
            $table->text('activity_name')->nullable();
            $table->integer('month');
            $table->enum('factor', ['numerador', 'denominador']);
            $table->string('commune')->nullable();
            $table->string('establishment')->nullable();
            $table->integer('value')->default(0);

            $table->morphs('valueable');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');

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
        Schema::dropIfExists('ind_values');
    }
};
