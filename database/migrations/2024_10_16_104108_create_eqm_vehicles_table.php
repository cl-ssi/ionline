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
        Schema::create('eqm_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->nullable()->constrained('cl_regions'); //recintos
            $table->foreignId('establishment_id')->nullable()->constrained('establishments'); //recintos
            $table->string('body_type'); // TIPO CARROCERÍA
            $table->string('ambulance_type'); // TIPO AMBULANCIA
            $table->string('ambulance_class'); // CLASE DE AMBULANCIA
            $table->boolean('samu'); // SAMU (SI / NO)
            $table->string('function'); // FUNCIÓN
            $table->foreignId('brand_id')->nullable()->constrained('eqm_brands'); //clase
            $table->string('model'); // MODELO
            $table->string('license_plate'); // N° PATENTE
            $table->string('engine_number'); // N° MOTOR
            $table->integer('mileage')->nullable(); // KILOMETRAJE
            $table->string('ownership_status'); // ESTADO SITUACIÓN
            $table->string('conservation_status'); // ESTADO DE CONSERVACIÓN
            $table->year('acquisition_year'); // AÑO ADQUISICIÓN
            $table->integer('useful_life'); // VIDA ÚTIL
            $table->integer('residual_useful_life'); // VIDA ÚTIL RESIDUAL
            $table->boolean('critical'); // CRÍTICO / NO CRÍTICO
            $table->boolean('under_warranty'); // EN GARANTÍA (SI / NO)
            $table->string('warranty_expiry_year'); // AÑO VENCIMIENTO GARANTÍA
            $table->boolean('under_maintenance_plan'); // BAJO PLAN DE MANTENIMIENTO (SI / NO)
            $table->year('year_entered_maintenance_plan'); // AÑO INGRESO A PLAN DE MANTENIMIENTO (2023 / 2024 / 2025 / 2026)
            $table->string('internal_or_external_maintenance'); // MANTENIMIENTO INTERNO O MANTENIMIENTO EXTERNO
            $table->string('provider_or_internal_maintenance')->nullable(); // NOMBRE DE PROVEEDOR O MANTENIMIENTO INTERNO
            $table->string('maintenance_agreement_id_or_reference')->nullable(); // ID CONVENIO DE MANTENIMIENTO
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
        Schema::dropIfExists('eqm_vehicles');
    }
};
