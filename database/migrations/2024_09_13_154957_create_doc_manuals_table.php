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
        Schema::create('doc_manuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('cfg_modules');
            $table->foreignId('author_id')->nullable()->constrained('users');
            $table->float('version')->default(1);
            $table->string('title');
            $table->text('content');
            $table->text('modifications')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_manuals');
    }
};
