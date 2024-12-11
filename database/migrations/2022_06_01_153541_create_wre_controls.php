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
        Schema::create('wre_controls', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->nullable(); // 1:ingreso 0:egreso
            $table->boolean('confirm')->nullable(); // 1:si 0:no
            $table->date('date')->nullable();
            $table->text('note')->nullable();
            $table->string('po_code', 255)->nullable();
            $table->datetime('po_date')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number', 255)->nullable();
            $table->date('document_date')->nullable();
            $table->boolean('status')->nullable(); // 1:abierto 0:cerrado
            $table->boolean('completed_invoices', 1)->nullable();
            $table->foreignId('type_dispatch_id')->nullable()->constrained('wre_type_dispatches');
            $table->foreignId('type_reception_id')->nullable()->constrained('wre_type_receptions');
            $table->foreignId('store_id')->nullable()->constrained('wre_stores');
            $table->foreignId('origin_id')->nullable()->constrained('wre_origins');
            $table->foreignId('destination_id')->nullable()->constrained('wre_destinations');
            $table->foreignId('store_origin_id')->nullable()->constrained('wre_stores');
            $table->foreignId('store_destination_id')->nullable()->constrained('wre_stores');
            $table->foreignId('supplier_id')->nullable()->constrained('cfg_suppliers');
            $table->foreignId('program_id')->nullable()->constrained('cfg_programs');
            $table->foreignId('po_id')->nullable()->constrained('arq_purchase_orders');
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->foreignId('reception_visator_id')->nullable()->constrained('users');
            $table->foreignId('technical_signature_id')->nullable()->constrained('doc_signatures');
            $table->foreignId('technical_signer_id')->nullable()->constrained('users');
            $table->boolean('require_contract_manager_visation')->nullable();
            $table->foreignId('visation_contract_manager_user_id')->nullable()->constrained('users');
            $table->foreignId('visation_contract_manager_ou')->nullable()->constrained('organizational_units');
            $table->datetime('visation_contract_manager_at')->nullable();
            $table->boolean('visation_contract_manager_status')->nullable();
            $table->text('visation_warehouse_manager_rejection_observation')->nullable();
            $table->text('visation_contract_manager_rejection_observation')->nullable();
            $table->foreignId('visation_warehouse_manager_user_id')->nullable()->constrained('users');
            $table->foreignId('visation_warehouse_manager_ou')->nullable()->constrained('organizational_units');
            $table->datetime('visation_warehouse_manager_at')->nullable();
            $table->boolean('visation_warehouse_manager_status')->nullable();
            $table->foreignId('reception_id')->nullable()->constrained('fin_receptions');

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
        Schema::dropIfExists('wre_controls');
    }
};
