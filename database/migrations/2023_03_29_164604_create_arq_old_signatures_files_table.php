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
        Schema::create('arq_old_signatures_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_form_id')->constrained('arq_request_forms');
            $table->foreignId('old_signature_file_id')->constrained('doc_signatures_files');
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
        Schema::dropIfExists('arq_old_signatures_files');
    }
};
