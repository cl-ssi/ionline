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
        Schema::create('req_requirements', function (Blueprint $table) {
            $table->id();
            $table->text('subject');
            $table->enum('priority', ['normal', 'urgente']);
            $table->enum('status', ['creado', 'respondido', 'cerrado', 'derivado', 'reabierto']);
            //$table->boolean('archived')->default(0);
            $table->datetime('limit_at')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parte_id')->nullable()->constrained('partes');
            $table->integer('group_number')->nullable();
            $table->boolean('to_authority')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('req_categories');
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
            //$table->foreign('to')->references('id')->on('users');
        });

        Schema::create('req_labels_requirements', function (Blueprint $table) {
            $table->foreignId('requirement_id')->constrained('req_requirements')->onDelete('cascade');
            $table->foreignId('label_id')->nullable()->constrained('req_labels');
            //$table->foreignId('category_id')->constrained('req_categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('req_requirements_status', function (Blueprint $table) {
            $table->foreignId('requirement_id')->constrained('req_requirements')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['not viewed', 'viewed', 'archived']);
            //$table->integer('category_id')->unsigned();
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
        Schema::dropIfExists('req_labels_requirements');
        Schema::dropIfExists('req_requirements_status');
        Schema::dropIfExists('req_requirements');
    }
};
