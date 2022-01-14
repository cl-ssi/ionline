<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqAttachedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_attached_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('document_type')->nullable();
            $table->foreignId('tender_id')->nullable()->constrained('arq_tenders');

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
        Schema::dropIfExists('arq_attached_files');
    }
}
