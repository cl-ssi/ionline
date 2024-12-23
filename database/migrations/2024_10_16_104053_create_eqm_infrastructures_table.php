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
        Schema::create('eqm_infrastructures', function (Blueprint $table) {
            $table->id();
            // $table->string('building_name'); // NOMBRE DE EDIFICIO
            // $table->string('sector_or_area'); // RECINTO O SECTOR
            $table->foreignId('place_id')->nullable()->constrained('cfg_places'); //recintos
            $table->foreignId('location_id')->nullable()->constrained('cfg_locations'); //ubicaciones
            $table->string('infrastructure_element_or_specialty'); // ELEMENTO DE INFRAESTRUCTURA A INTERVENIR O ESPECIALIDAD
            $table->text('intervention_type_description'); // TIPO DE INTERVENCIÓN (DESCRIPCIÓN)
            $table->integer('quantity'); // CANTIDAD
            $table->string('condition'); // ESTADO (BUENO / REGULAR / MALO)
            $table->string('norm_accreditation_or_not_applicable'); // NORMATIVA / ACREDITACIÓN / NO APLICA
            $table->boolean('under_warranty'); // EN GARANTÍA (SI / NO)
            $table->string('warranty_expiry_year'); // AÑO VENCIMIENTO GARANTÍA
            $table->boolean('under_maintenance_plan'); // BAJO PLAN DE MANTENIMIENTO (SI / NO)
            $table->year('year_entered_maintenance_plan'); // AÑO INGRESO A PLAN DE MANTENIMIENTO (2024 / 2025 / 2026)
            $table->string('internal_or_external_maintenance'); // MANTENIMIENTO INTERNO O MANTENIMIENTO EXTERNO O CONTRATO
            $table->string('provider_or_internal_maintenance')->nullable(); // NOMBRE DE PROVEEDOR O MANTENIMIENTO INTERNO
            $table->string('maintenance_agreement_id_or_reference')->nullable(); // ID CONVENIO DE MANTENIMIENTO / ID DE REFERENCIA / COTIZACIÓN DE REFERENCIA
            $table->decimal('annual_maintenance_cost', 10, 2); // COSTO ANUAL DE MANTENIMIENTO SEGÚN CONVENIO / PRECIO DE REFERENCIA MANTENIMIENTO ANUAL
            $table->integer('annual_maintenance_frequency'); // FRECUENCIA ANUAL DE MANTENIMIENTO

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eqm_infrastructures');
    }
};
