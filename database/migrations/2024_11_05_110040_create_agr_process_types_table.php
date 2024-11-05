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
        Schema::create('agr_process_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('template')->nullable();
            $table->boolean('is_dependent')->default(false);
            $table->boolean('has_resolution')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        //add foreign key to same table
        // Schema::table('agr_process_types', function (Blueprint $table) {
        //     $table->foreignId('parent_id')->after('has_resolution')->nullable()->constrained('agr_process_types')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agr_process_types');
    }
};
