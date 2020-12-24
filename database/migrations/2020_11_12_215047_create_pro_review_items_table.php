<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProReviewItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_review_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->string('review')->nullable();
            $table->text('observation')->nullable();
            $table->enum('answer',['SI','NO','REGULAR'])->nullable();
            $table->enum('active',['SI','NO'])->nullable();

            $table->unsignedBigInteger('user_id');
            $table->enum('rectified',['SI','NO'])->default('NO')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->bigInteger('programming_item_id')->unsigned();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('programming_item_id')->references('id')->on('pro_programming_items');
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
        Schema::dropIfExists('pro_review_items');
    }
}
