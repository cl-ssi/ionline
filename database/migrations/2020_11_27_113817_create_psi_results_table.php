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
        Schema::create('psi_results', function (Blueprint $table) {
            $table->id();
            $table->integer('total_points')->nullable();
            $table->foreignId('user_id')->constrained('users_external');
            $table->foreignId('request_id')->constrained('psi_requests');
            $table->foreignId('signed_certificate_id')->nullable()->constrained('doc_signatures_files');
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
        Schema::dropIfExists('psi_results');
    }
};
