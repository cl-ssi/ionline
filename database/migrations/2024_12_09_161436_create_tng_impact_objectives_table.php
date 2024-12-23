<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Trainings\ImpactObjectives;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tng_impact_objectives', function (Blueprint $table) {
            $table->id();

            $table->longText('description')->nullable();
            $table->foreignId('strategic_axis_id')->nullable()->constrained('tng_strategic_axes');

            $table->timestamps();
            $table->softDeletes();
        });

        /* Se elimina el campo descripción.
        Schema::table('tng_strategic_axes', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        //  Enfermedades Transmisibles.
        ImpactObjectives::Create([
            'description'       => 'Disminuir la incidencia de VIH/SIDA',
            'strategic_axis_id' =>  1
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir la incidencia de Tuberculosis',
            'strategic_axis_id' =>  1
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la incidencia de casos de Enfermedades Zoonóticas y Vectoriales',
            'strategic_axis_id' =>  1
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir el riesgo de reintroducción o aumento de Enfermedades Transmisibles en vías de Eliminación',
            'strategic_axis_id' =>  1
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la morbimortalidad por Infecciones Respiratorias Agudas',
            'strategic_axis_id' =>  1
        ]);

        //  Enfermedades No Transmisibles.
        ImpactObjectives::Create([
            'description'       => 'Disminuir la mortalidad prematura por Cáncer',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la morbimortalidad por Enfermedades Cardiovasculares y Cerebrovasculares',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mejorar la cobertura y la efectividad del manejo de Diabetes Mellitus',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la progresión de la Enfermedad Renal Crónica',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la morbimortalidad por Enfermedades Respiratorias Crónicas',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la prevalencia de dolor crónico asociada a Alteraciones Musculoesqueléticas',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir la morbilidad y mortalidad en exceso asociada a Condiciones Mentales',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mejorar el estado de Salud Bucal de la población',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la Discapacidad Severa y la Dependencia',
            'strategic_axis_id' =>  2
        ]);
        ImpactObjectives::Create([
            'description'       => 'Enfrentar los desafíos específicos de las Enfermedades no Transmisibles',
            'strategic_axis_id' =>  2
        ]);

        //  Lesiones y Violencia
        ImpactObjectives::Create([
            'description'       => 'Enfrentar los desafíos específicos de las Enfermedades no Transmisibles',
            'strategic_axis_id' =>  3
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la morbimortalidad asociada a Violencia',
            'strategic_axis_id' =>  3
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la mortalidad por Suicidio',
            'strategic_axis_id' =>  3
        ]);

        //  Estilos de Vida y Factores de Riesgo 
        ImpactObjectives::Create([
            'description'       => 'Aumentar la prevalencia de personas con Factores Protectores de Salud',
            'strategic_axis_id' =>  4
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la prevalencia de consumo de productos de Tabaco y de sistemas electrónicos de administración de nicotina y sin nicotina',
            'strategic_axis_id' =>  4
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir el consumo de Alcohol y sus consecuencias sociales y sanitarias',
            'strategic_axis_id' =>  4
        ]);
        ImpactObjectives::Create([
            'description'       => 'Aumentar la conducta sexual segura',
            'strategic_axis_id' =>  4
        ]);
        ImpactObjectives::Create([
            'description'       => 'Detener la aceleración de la prevalencia de sobrepeso y obesidad a lo largo del curso de vida',
            'strategic_axis_id' =>  4
        ]);
        ImpactObjectives::Create([
            'description'       => 'Aumentar la prevalencia de Actividad Física Suficiente',
            'strategic_axis_id' =>  4
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mejorar la Salud Mental con enfoque promocional y preventivo',
            'strategic_axis_id' =>  4
        ]);

        //  Curso de Vida
        ImpactObjectives::Create([
            'description'       => 'Mejorar la Salud Mental con enfoque promocional y preventivo',
            'strategic_axis_id' =>  5
        ]);
        ImpactObjectives::Create([
            'description'       => 'Aumentar la prevalencia de niños y niñas que alcanzan su desarrollo integral',
            'strategic_axis_id' =>  5
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mejorar integralmente la Salud Sexual y Salud Reproductiva con enfoque de derechos',
            'strategic_axis_id' =>  5
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir la morbimortalidad asociada a condiciones y organización del trabajo',
            'strategic_axis_id' =>  5
        ]);
        ImpactObjectives::Create([
            'description'       => 'Prevenir el deterioro del funcionamiento en Personas Mayores',
            'strategic_axis_id' =>  5
        ]);

        //  Equidad
        ImpactObjectives::Create([
            'description'       => 'Mejorar la Salud Mental con enfoque promocional y preventivo',
            'strategic_axis_id' =>  6
        ]);
        ImpactObjectives::Create([
            'description'       => 'Disminuir las inequidades en salud de la Población Indígena',
            'strategic_axis_id' =>  6
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir las inequidades en el acceso efectivo a la atención en salud de Personas Migrantes',
            'strategic_axis_id' =>  6
        ]);

        //  Medio Ambiente
        ImpactObjectives::Create([
            'description'       => 'Reducir la población expuesta a condiciones sanitario-ambientales desfavorables',
            'strategic_axis_id' =>  7
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir la población expuesta a Alimentos no Inocuos',
            'strategic_axis_id' =>  7
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir el riesgo de emergencia y diseminación de Resistencia a los antimicrobianos',
            'strategic_axis_id' =>  7
        ]);
        ImpactObjectives::Create([
            'description'       => 'Reducir el impacto negativo en la salud por efecto del Cambio Climático',
            'strategic_axis_id' =>  7
        ]);

        //  Sistema de Salud
        ImpactObjectives::Create([
            'description'       => 'Fortalecer el cuidado de la salud, centrado en las personas, familias y comunidades avanzando hacia la cobertura universal',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Aumentar la equidad territorial en la distribución de Recursos Humanos en el sistema público de salud',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer la Infraestructura y Equipamiento del sector con enfoque de equidad',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mejorar el Financiamiento Público destinado a salud',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer un Modelo de Gestión Participativa en Salud',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer el cuidado de la salud, centrado en las personas, familias y comunidades avanzando hacia la cobertura universal',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Desarrollar un modelo de atención de Salud Digital sostenible, que aporte al acceso, la atención oportuna y la información a los pacientes',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mantener la Participación y Cooperación internacional en salud',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer la Investigación asociada a procesos de toma de decisiones en políticas públicas de salud',
            'strategic_axis_id' =>  8
        ]);
        ImpactObjectives::Create([
            'description'       => 'Mitigar los efectos de las Emergencias y Desastres en la salud y bienestar',
            'strategic_axis_id' =>  8
        ]);

        //  Calidad de la Atención
        ImpactObjectives::Create([
            'description'       => 'Fortalecer la entrega de servicios de salud con equidad, calidad y énfasis en Eficacia',
            'strategic_axis_id' =>  9
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer la entrega de servicios de salud con equidad, calidad y énfasis en Acceso',
            'strategic_axis_id' =>  9
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer la entrega de servicios de salud con equidad, calidad y énfasis en Seguridad',
            'strategic_axis_id' =>  9
        ]);
        ImpactObjectives::Create([
            'description'       => 'Fortalecer la entrega de servicios de salud con equidad, calidad y énfasis en Satisfacción Usuaria',
            'strategic_axis_id' =>  9
        ]);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tng_impact_objectives');
    }
};
