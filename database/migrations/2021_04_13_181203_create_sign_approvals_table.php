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
        Schema::create('sign_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('module_icon')->nullable();
            $table->string('subject');
            $table->string('document_route_name')->nullable();
            $table->string('document_route_params')->nullable();
            $table->string('document_pdf_path')->nullable();

            $table->foreignId('sent_to_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('sent_to_user_id')->nullable()->constrained('users');
            $table->string('initials', 6)->nullable();

            $table->foreignId('approver_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('approver_id')->nullable()->constrained('users');
            $table->string('approver_observation')->nullable();
            $table->datetime('approver_at')->nullable();

            $table->boolean('status')->nullable()->default(0); // Usando TINYINT con valor predeterminado
            $table->boolean('approvable_callback')->default(false);
            $table->string('callback_controller_method')->nullable();
            $table->string('callback_controller_params')->nullable();
            $table->text('callback_feedback_inputs')->nullable();

            $table->boolean('active')->default(true);
            $table->boolean('digital_signature')->default(false);
            $table->boolean('endorse')->default(false);

            $table->string('position')->nullable();
            $table->integer('start_y')->nullable();
            $table->string('filename')->nullable();

            $table->nullableMorphs('approvable'); // Manteniendo morfología
            $table->timestamps();
            $table->softDeletes();

            $table->index(['active']);
        });

        // Añadir clave foránea después de crear la tabla
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->foreignId('previous_approval_id')->after('active')->nullable()->constrained('sign_approvals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sign_approvals', function (Blueprint $table) {
            $table->dropForeign(['previous_approval_id']);
            $table->dropColumn('previous_approval_id');
        });

        Schema::dropIfExists('sign_approvals');
    }
};
