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
        Schema::create('arq_immediate_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_type_id')->nullable()->constrained('cfg_purchase_types');
            $table->string('cot_id')->nullable();
            $table->string('po_id')->nullable();
            $table->dateTime('po_date');
            $table->dateTime('po_sent_date');
            $table->dateTime('po_accepted_date');
            $table->date('po_with_confirmed_receipt_date')->nullable();
            $table->float('po_discounts', 15, 2)->nullable();
            $table->float('po_charges', 15, 2)->nullable();
            $table->float('po_net_amount', 15, 2)->nullable();
            $table->float('po_tax_percent')->nullable();
            $table->float('po_tax_amount', 15, 2)->nullable();
            $table->string('po_supplier_name')->nullable();
            $table->string('po_supplier_activity')->nullable();
            $table->string('po_supplier_office_name')->nullable();
            $table->string('po_supplier_office_run')->nullable();
            $table->string('po_supplier_address')->nullable();
            $table->string('po_supplier_commune')->nullable();
            $table->string('po_supplier_region')->nullable();
            $table->string('po_supplier_contact_name')->nullable();
            $table->string('po_supplier_contact_position')->nullable();
            $table->string('po_supplier_contact_phone')->nullable();
            $table->string('po_supplier_contact_email')->nullable();
            $table->float('po_amount', 15, 2)->nullable();
            $table->dateTime('estimated_delivery_date');
            $table->string('days_type_delivery')->nullable();
            $table->integer('days_delivery')->nullable();
            $table->text('description')->nullable();
            $table->string('resol_supplementary_agree')->nullable();
            $table->string('resol_awarding')->nullable();
            $table->string('resol_purchase_intention')->nullable();
            $table->string('po_status')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('cfg_suppliers');
            $table->foreignId('tender_id')->nullable()->constrained('arq_tenders');
            $table->foreignId('direct_deal_id')->nullable()->constrained('arq_direct_deals');
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->string('destination_warehouse')->nullable();
            $table->text('supplier_specifications')->nullable();

            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_immediate_purchases');
    }
};
