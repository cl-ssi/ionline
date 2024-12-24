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
        Schema::create('sign_signature_requests', function (Blueprint $table) {
            $table->id();
            $table->dateTime('request_date');
            $table->foreignId('type_id')->constrained('doc_types');
            $table->string('original_file_path');
            $table->string('original_file_name');
            $table->string('url')->nullable();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->text('recipients')->nullable();
            $table->text('distribution')->nullable();
            $table->boolean('reserved')->default(false);
            $table->boolean('oficial')->default(false);
            $table->boolean('sensitive')->default(false);
            $table->boolean('signature_page_lastpage')->default(false);
            $table->unsignedTinyInteger('signature_page_number')->nullable();
            $table->unsignedTinyInteger('response_within_days')->nullable();
            $table->enum('endorse_type', ['without', 'optional', 'chain']);
            $table->string('verification_code')->nullable();
            $table->foreignId('last_approval_id')->nullable()->constrained('sign_approvals');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sign_signature_requests');
    }
};
