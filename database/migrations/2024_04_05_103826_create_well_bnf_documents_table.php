<?php

use App\Models\Welfare\Benefits\Document;
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
        Schema::create('well_bnf_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subsidy_id')->constrained('well_bnf_subsidies');
            $table->text('type'); //documentación - requisito
            $table->text('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Document::create([
            'subsidy_id' => 1,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado por fonasa (solicitar en fonasa) o Isapre',
        ]);

        Document::create([
            'subsidy_id' => 1,
            'type'       => 'Documentación',
            'name'       => 'Boleta del profesional o clínica.',
        ]);

        Document::create([
            'subsidy_id' => 2,
            'type'       => 'Documentación',
            'name'       => 'Receta médica original adjuntando boleta de gastos.',
        ]);

        Document::create([
            'subsidy_id' => 2,
            'type'       => 'Documentación',
            'name'       => 'Para receta de uso permanente fotocopia timbrada por la farmacia (duración 2 años).',
        ]);

        Document::create([
            'subsidy_id' => 2,
            'type'       => 'Documentación',
            'name'       => 'Para receta retenida fotocopia visada con timbre retenido por la farmacia.',
        ]);

        Document::create([
            'subsidy_id' => 3,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado por fonasa (solicitar en fonasa) o Isapre.',
        ]);

        Document::create([
            'subsidy_id' => 3,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del pago.',
        ]);

        Document::create([
            'subsidy_id' => 4,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.',
        ]);

        Document::create([
            'subsidy_id' => 4,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional.',
        ]);

        Document::create([
            'subsidy_id' => 5,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.',
        ]);

        Document::create([
            'subsidy_id' => 5,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional',
        ]);

        Document::create([
            'subsidy_id' => 6,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.',
        ]);

        Document::create([
            'subsidy_id' => 6,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional',
        ]);

        Document::create([
            'subsidy_id' => 7,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.',
        ]);

        Document::create([
            'subsidy_id' => 7,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional.',
        ]);

        Document::create([
            'subsidy_id' => 8,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.-',
        ]);

        Document::create([
            'subsidy_id' => 8,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional.-',
        ]);

        Document::create([
            'subsidy_id' => 8,
            'type'       => 'Documentación',
            'name'       => 'Adjuntar programa.-',
        ]);

        Document::create([
            'subsidy_id' => 9,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.-',
        ]);

        Document::create([
            'subsidy_id' => 9,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional.-',
        ]);

        Document::create([
            'subsidy_id' => 9,
            'type'       => 'Documentación',
            'name'       => 'Nota: Adjuntar programa.-',
        ]);

        Document::create([
            'subsidy_id' => 10,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.-',
        ]);

        Document::create([
            'subsidy_id' => 10,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional.-',
        ]);

        Document::create([
            'subsidy_id' => 10,
            'type'       => 'Documentación',
            'name'       => 'Nota: Adjuntar programa',
        ]);

        Document::create([
            'subsidy_id' => 11,
            'type'       => 'Documentación',
            'name'       => 'Copia Bono entregado (solicitar en fonasa) o Isapre.',
        ]);

        Document::create([
            'subsidy_id' => 11,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura del profesional.',
        ]);

        Document::create([
            'subsidy_id' => 11,
            'type'       => 'Documentación',
            'name'       => 'Nota: Adjuntar programa',
        ]);

        Document::create([
            'subsidy_id' => 12,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura indicando el detalle de la atención.',
        ]);

        Document::create([
            'subsidy_id' => 13,
            'type'       => 'Documentación',
            'name'       => 'Receta Médica.',
        ]);

        Document::create([
            'subsidy_id' => 13,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura de pago.',
        ]);

        Document::create([
            'subsidy_id' => 13,
            'type'       => 'Documentación',
            'name'       => 'En el caso de que desee ocupar óptica en convenio, adjuntar presupuesto de la óptica.',
        ]);

        Document::create([
            'subsidy_id' => 14,
            'type'       => 'Documentación',
            'name'       => 'Receta Médica.-',
        ]);

        Document::create([
            'subsidy_id' => 14,
            'type'       => 'Documentación',
            'name'       => 'Boleta o factura de pago',
        ]);

        Document::create([
            'subsidy_id' => 15,
            'type'       => 'Documentación',
            'name'       => 'Boleta, Bono o Factura.',
        ]);

        Document::create([
            'subsidy_id' => 16,
            'type'       => 'Documentación',
            'name'       => 'Certificado Matrimonio',
        ]);

        Document::create([
            'subsidy_id' => 17,
            'type'       => 'Documentación',
            'name'       => 'Certificado Matrimonio',
        ]);

        Document::create([
            'subsidy_id' => 18,
            'type'       => 'Documentación',
            'name'       => 'Certificado Defunción.',
        ]);

        Document::create([
            'subsidy_id' => 19,
            'type'       => 'Documentación',
            'name'       => 'Certificado de bomberos o autoridad competente.',
        ]);

        Document::create([
            'subsidy_id' => 20,
            'type'       => 'Documentación',
            'name'       => 'Certificado de alumno regular (no se acepta certificado de matrícula).',
        ]);

        Document::create([
            'subsidy_id' => 20,
            'type'       => 'Documentación',
            'name'       => 'Cotizaciones tres meses antes del mes de entrega del beneficio (primera cotización en el mes de diciembre del años anterior a la entrega del beneficio).',
        ]);

        Document::create([
            'subsidy_id' => 21,
            'type'       => 'Documentación',
            'name'       => 'Certificado de alumno regular (no se acepta certificado de matrícula).',
        ]);

        Document::create([
            'subsidy_id' => 21,
            'type'       => 'Documentación',
            'name'       => 'Cotizaciones tres meses antes del mes de entrega del beneficio (primera cotización en el mes de diciembre del años anterior a la entrega del beneficio).',
        ]);

        Document::create([
            'subsidy_id' => 22,
            'type'       => 'Documentación',
            'name'       => 'Certificado de alumno regular (no se acepta certificado de matrícula).',
        ]);

        Document::create([
            'subsidy_id' => 22,
            'type'       => 'Documentación',
            'name'       => 'Cotizaciones tres meses antes del mes de entrega del beneficio (primera cotización en el mes de diciembre del años anterior a la entrega del beneficio).',
        ]);

        Document::create([
            'subsidy_id' => 23,
            'type'       => 'Documentación',
            'name'       => 'Certificado de alumno regular (no se acepta certificado de matrícula).',
        ]);

        Document::create([
            'subsidy_id' => 23,
            'type'       => 'Documentación',
            'name'       => 'Cotizaciones tres meses antes del mes de entrega del beneficio (primera cotización en el mes de diciembre del años anterior a la entrega del beneficio).',
        ]);

        Document::create([
            'subsidy_id' => 24,
            'type'       => 'Documentación',
            'name'       => 'Certificado de alumno regular (no se acepta certificado de matrícula).',
        ]);

        Document::create([
            'subsidy_id' => 24,
            'type'       => 'Documentación',
            'name'       => 'Cotizaciones tres meses antes del mes de entrega del beneficio (primera cotización en el mes de diciembre del años anterior a la entrega del beneficio).',
        ]);

        Document::create([
            'subsidy_id' => 25,
            'type'       => 'Requisitos',
            'name'       => 'Ser socio de bienestar mínimo de 6 meses.',
        ]);

        Document::create([
            'subsidy_id' => 25,
            'type'       => 'Requisitos',
            'name'       => 'Ser alumno regular de segundo año carrera universitaria.',
        ]);

        Document::create([
            'subsidy_id' => 25,
            'type'       => 'Requisitos',
            'name'       => 'Tener promedio de nota del año anterior mínimo 5.0.',
        ]);

        Document::create([
            'subsidy_id' => 25,
            'type'       => 'Requisitos',
            'name'       => 'No tener ramos reprobados.',
        ]);

        Document::create([
            'subsidy_id' => 25,
            'type'       => 'Requisitos',
            'name'       => 'No poseer otras becas públicas o privadas.',
        ]);

        Document::create([
            'subsidy_id' => 25,
            'type'       => 'Requisitos',
            'name'       => 'No estar en posesión de título Profesional previo.',
        ]);

        Document::create([
            'subsidy_id' => 26,
            'type'       => 'Documentación',
            'name'       => 'Cotizaciones seis meses antes del mes de entrega (primera cotización mes de Julio).',
        ]);

        Document::create([
            'subsidy_id' => 27,
            'type'       => 'Documentación',
            'name'       => 'Solicitud con 2 avales. (copia C.I)',
        ]);

        Document::create([
            'subsidy_id' => 27,
            'type'       => 'Documentación',
            'name'       => 'Antecedentes Médicos necesarios de respaldo, como presupuestos médicos.',
        ]);

        Document::create([
            'subsidy_id' => 27,
            'type'       => 'Documentación',
            'name'       => 'Liquidación de Sueldos.',
        ]);

        Document::create([
            'subsidy_id' => 28,
            'type'       => 'Documentación',
            'name'       => 'Solicitud con 2 avales.(copia C.I)',
        ]);

        Document::create([
            'subsidy_id' => 28,
            'type'       => 'Documentación',
            'name'       => 'Liquidación de Sueldos.',
        ]);

        Document::create([
            'subsidy_id' => 29,
            'type'       => 'Documentación',
            'name'       => 'Solicitud con 2 avales. (copia C.I)',
        ]);

        Document::create([
            'subsidy_id' => 29,
            'type'       => 'Documentación',
            'name'       => 'Presupuesto y fotos del lugar a mejorar',
        ]);

        Document::create([
            'subsidy_id' => 29,
            'type'       => 'Documentación',
            'name'       => 'Pre-aprobación del banco por la compra de nueva vivienda.',
        ]);

        Document::create([
            'subsidy_id' => 29,
            'type'       => 'Documentación',
            'name'       => 'Liquidación de Sueldos.',
        ]);

        Document::create([
            'subsidy_id' => 30,
            'type'       => 'Documentación',
            'name'       => 'Solicitud con 2 avales. (copia C.I)',
        ]);

        Document::create([
            'subsidy_id' => 30,
            'type'       => 'Documentación',
            'name'       => 'Presupuesto y fotos del lugar a mejorar',
        ]);

        Document::create([
            'subsidy_id' => 30,
            'type'       => 'Documentación',
            'name'       => 'Pre-aprobación del banco por la compra de nueva vivienda.',
        ]);

        Document::create([
            'subsidy_id' => 30,
            'type'       => 'Documentación',
            'name'       => 'Liquidación de Sueldos.',
        ]);

        Document::create([
            'subsidy_id' => 31,
            'type'       => 'Requisitos',
            'name'       => 'Las RESERVAS se aperturan desde el primer día hábil de cada mes, solo vía email bienestariquique@redsalud.gov.cl por orden de llegada según horario de oficina desde 8:30 a 17:00 de lunes a viernes. Siendo el máximo de días a utilizar de 5 días a fin de dar mayor cobertura a otros socios.',
        ]);

        Document::create([
            'subsidy_id' => 32,
            'type'       => 'Requisitos',
            'name'       => 'Las RESERVAS se aperturan desde el primer día hábil de cada mes, solo vía email bienestariquique@redsalud.gov.cl por orden de llegada según horario de oficina desde 8:30 a 17:00 de lunes a viernes. Siendo el máximo de días a utilizar de 5 días a fin de dar mayor cobertura a otros socios.',
        ]);

        Document::create([
            'subsidy_id' => 33,
            'type'       => 'Requisitos',
            'name'       => 'Las RESERVAS se aperturan desde el primer día hábil de cada mes, solo vía email bienestariquique@redsalud.gov.cl por orden de llegada según horario de oficina desde 8:30 a 17:00 de lunes a viernes. Siendo el máximo de días a utilizar de 5 días a fin de dar mayor cobertura a otros socios.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_bnf_documents');
    }
};
