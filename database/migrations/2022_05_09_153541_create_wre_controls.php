<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWreControls extends Migration
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
            $table->string('invoice_number', 255)->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('guide_number', 255)->nullable();
            $table->date('guide_date')->nullable();

            $table->boolean('status')->nullable(); // 1:abierto 0:cerrado

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
}
