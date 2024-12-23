<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agr_signers', function (Blueprint $table) {
            $table->id();
            $table->string('appellative'); // APELATIVO DIRECTOR, DIRECTOR (S)
            $table->text('decree'); // DECRETO DIRECTOR
            $table->foreignId('user_id')->constrained('users'); // DIRECTOR USER ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agr_signers');
    }
};
