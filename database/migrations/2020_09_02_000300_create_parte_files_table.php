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
        Schema::create('parte_files', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('parte_id')->constrained('partes')->onDelete('cascade');
            $table->foreignId('signature_file_id')->nullable()->constrained('doc_signatures_files');
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
        Schema::dropIfExists('parte_files');
    }
};
