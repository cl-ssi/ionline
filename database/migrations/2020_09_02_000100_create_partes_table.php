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
        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('correlative')->default(0);
            $table->datetime('entered_at');
            $table->foreignId('type_id')->constrained('doc_types');
            $table->boolean('reserved')->nullable();
            $table->date('date');
            $table->integer('number')->unsigned()->nullable();
            //$table->unsignedBigInteger('organizational_unit_id')->nullable();
            $table->string('origin')->nullable();
            $table->text('subject');
            $table->boolean('important')->nullable();
            $table->boolean('physical_format')->nullable();
            $table->foreignId('received_by_id')->nullable()->constrained('users');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('signatures_file_id')->nullable()->constrained('doc_signatures_files');
            $table->datetime('reception_date')->nullable();
            $table->timestamp('viewed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
            //$table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partes');
    }
};
