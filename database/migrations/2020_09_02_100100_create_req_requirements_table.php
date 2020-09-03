<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('subject');
            $table->enum('priority',['normal','urgente']);
            $table->enum('status',['creado','respondido','cerrado','derivado','reabierto']);
            //$table->boolean('archived')->default(0);
            $table->datetime('limit_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parte_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            //$table->foreign('to')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('parte_id')->references('id')->on('partes');
        });

        Schema::create('req_requirements_categories', function (Blueprint $table) {
            $table->bigInteger('requirement_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->foreign('requirement_id')->references('id')->on('req_requirements')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('req_categories')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('req_requirements_status', function (Blueprint $table) {
            $table->bigInteger('requirement_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status',['not viewed','viewed','archived']);
            //$table->integer('category_id')->unsigned();

            $table->foreign('requirement_id')->references('id')->on('req_requirements')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('req_requirements_categories');
        Schema::dropIfExists('req_requirements_status');
        Schema::dropIfExists('req_requirements');
    }
}
