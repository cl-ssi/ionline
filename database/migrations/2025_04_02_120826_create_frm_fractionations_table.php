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
        Schema::create('frm_fractionations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('pharmacy_id')->constrained('frm_pharmacies'); //origen
            $table->foreignId('origin_establishment_id')->constrained('establishments');

            $table->bigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('frm_patients');
            $table->string('acquirer')->nullable();
            $table->foreignId('medic_id')->constrained('users');
            $table->foreignId('qf_supervisor_id')->constrained('users');
            $table->foreignId('fractionator_id')->constrained('users');

            $table->longText('notes')->nullable(); //notas
            $table->foreignId('inventory_adjustment_id')->nullable()->constrained('frm_inventory_adjustments');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('frm_fractionation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fractionation_id')->constrained('frm_fractionations')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('frm_products');
            $table->double('amount', 8, 2); //cantidad
            $table->string('unity');
            $table->dateTime('due_date')->nullable(); //fecha vencimiento
            $table->longText('batch'); //lote
            $table->foreignId('batch_id')->nullable()->constrained('frm_batchs');
            $table->string('health_record')->nullable(); //registro sanitario

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frm_fractionation_items');
        Schema::dropIfExists('frm_fractionations');
    }
};
