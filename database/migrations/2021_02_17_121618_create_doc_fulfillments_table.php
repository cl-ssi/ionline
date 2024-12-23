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
        Schema::create('doc_fulfillments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('doc_service_requests');
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->string('type', 100)->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('observation', 100)->nullable();

            $table->boolean('responsable_approbation')->nullable();
            $table->datetime('responsable_approbation_date')->nullable();
            $table->foreignId('responsable_approver_id')->nullable()->constrained('users');

            $table->boolean('rrhh_approbation')->nullable();
            $table->datetime('rrhh_approbation_date')->nullable();
            $table->foreignId('rrhh_approver_id')->nullable()->constrained('users');

            $table->boolean('finances_approbation')->nullable();
            $table->datetime('finances_approbation_date')->nullable();
            $table->foreignId('finances_approver_id')->nullable()->constrained('users');

            $table->boolean('payment_ready')->nullable();
            $table->string('payment_rejection_detail')->nullable();
            $table->integer('contable_month')->nullable();
            $table->datetime('payment_date')->nullable();

            $table->double('total_paid', 10, 2)->nullable();
            $table->double('total_hours_paid', 10, 2)->nullable();
            $table->double('total_to_pay', 10, 2)->nullable();
            $table->dateTime('total_to_pay_at')->nullable();
            $table->double('total_hours_to_pay', 10, 2)->nullable();

            $table->bigInteger('bill_number')->nullable();
            $table->boolean('illness_leave')->nullable();
            $table->boolean('leave_of_absence')->nullable();
            $table->boolean('assistance')->nullable();
            $table->string('backup_assistance')->nullable();

            $table->boolean('has_invoice_file')->nullable();
            $table->dateTime('has_invoice_file_at')->nullable();
            $table->foreignId('has_invoice_file_user_id')->nullable()->constrained('users');

            $table->foreignId('signatures_file_id')->nullable()->constrained('doc_signatures_files');
            $table->foreignId('user_id')->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('doc_fulfillments_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fulfillment_id')->constrained('doc_fulfillments');
            $table->string('type', 100)->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('observation', 100)->nullable();

            $table->boolean('responsable_approbation')->nullable();
            $table->datetime('responsable_approbation_date')->nullable();
            $table->foreignId('responsable_approver_id')->nullable()->constrained('users');

            $table->boolean('rrhh_approbation')->nullable();
            $table->datetime('rrhh_approbation_date')->nullable();
            $table->foreignId('rrhh_approver_id')->nullable()->constrained('users');

            $table->boolean('finances_approbation')->nullable();
            $table->datetime('finances_approbation_date')->nullable();
            $table->foreignId('finances_approver_id')->nullable()->constrained('users');

            $table->foreignId('user_id')->constrained('users');

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
        Schema::dropIfExists('doc_fulfillments_items');
        Schema::dropIfExists('doc_fulfillments');
    }
};
