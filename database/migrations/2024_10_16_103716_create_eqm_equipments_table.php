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
        Schema::create('eqm_equipments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Industrial', 'Médico']);
            $table->foreignId('place_id')->nullable()->constrained('cfg_places'); //recintos
            $table->foreignId('location_id')->nullable()->constrained('cfg_locations'); //ubicaciones
            $table->foreignId('category_id')->nullable()->constrained('eqm_categories'); //clase
            $table->foreignId('subcategory_id')->nullable()->constrained('eqm_subcategories'); //subclase
            $table->string('name');
            $table->foreignId('brand_id')->nullable()->constrained('eqm_brands'); //clase
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('inventory_number')->nullable();
            $table->integer('acquisition_year')->nullable();
            $table->integer('useful_life')->nullable();
            $table->integer('residual_useful_life')->nullable();
            $table->string('property')->nullable(); // propio, arriendo, comodato
            $table->string('condition')->nullable(); // bueno, regular, malo
            $table->string('importance')->nullable(); // critico, relevante

            $table->string('compilance')->nullable(); // NORMATIVA / ACREDITACIÓN / IM≥4 / NO APLICA
            $table->string('assurance')->nullable(); // garantia si o no
            $table->string('warranty_expiry_year')->nullable(); // AÑO VENCIMIENTO GARANTÍA
            $table->string('under_maintenance_plan')->nullable(); // BAJO PLAN DE MANTENIMIENTO (SI / NO)
            $table->integer('year_entered_maintenance_plan')->nullable(); // AÑO INGRESO A PLAN DE MANTENIMIENTO (2023 / 2024 / 2025 / 2026)

            $table->string('type_of_maintenance')->nullable(); // mantenimiento interno, mantenimiento externo, contrato
            $table->foreignId('supplier_id')->nullable()->constrained('eqm_suppliers'); //proveedor
            $table->string('maintenance_reference')->nullable(); // id convenio de mantenimiento, id de referencia, cotización de referencia.
            $table->integer('annual_cost')->nullable();
            $table->integer('annual_maintenance_frequency')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eqm_equipments');
    }
};
