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
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('file_to_sign_id')->after('establishment_id')->nullable()->constrained('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('documents');
        Schema::table('documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('file_to_sign_id');
        });
    }
};
