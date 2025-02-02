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
        Schema::create('dnc_authorize_amounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('identify_need_id')->nullable()->constrained('dnc_identify_needs');
            $table->string('status')->nullable();
            $table->float('authorize_amount', 15, 2)->nullable();
            $table->float('executed_amount', 15, 2)->nullable();
            $table->text('observation')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnc_authorize_amounts');
    }
};
