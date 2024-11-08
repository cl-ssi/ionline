<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProProgrammingReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_programming_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('revisor')->nullable();
            $table->string('general_features')->nullable();
            $table->enum('answer',['SI','NO','REGULAR'])->nullable();
            $table->tinyInteger('score')->nullable();
            $table->text('observation')->nullable();
            $table->enum('active',['SI','NO'])->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreignId('user_id')->unsigned()->constrained('users');
            $table->foreignId('commune_file_id')->unsigned()->constrained('pro_commune_files');

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
        Schema::dropIfExists('pro_programming_reviews');
    }
}