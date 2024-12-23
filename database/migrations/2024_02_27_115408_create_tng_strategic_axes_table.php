<?php

use App\Models\Trainings\StrategicAxes;
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
        Schema::create('tng_strategic_axes', function (Blueprint $table) {
            $table->id();

            $table->string('number')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        StrategicAxes::Create([
            'number'        => '1',
            'name'          => 'MEDIO AMBIENTE Y ENTORNOS SALUDABLES',
            // 'description'   => 'Temas: Condiciones sanitario ambientales, Salud familiar y comunitaria, Salud ocupacional. Objetivo Institucional: Reducir la Población expuesta y/o vulnerable a condiciones sanitario ambientales desfavorables que afectan la salud y la calidad de vida, dentro de su territorio. Fortalecer el cuidado centrado en las personas, familias y comunidades avanzando hacia la cobertura universal. Disminuir la exposición de la población trabajadora a condiciones y organización del trabajo desfavorable que generan daños a la salud, afectando su seguridad y bienestar.',
        ]);

        StrategicAxes::Create([
            'number'        => '2',
            'name'          => 'ESTILOS DE VIDA',
            // 'description'   => 'Temas: Actividad Física, Alimentación Saludable e inocua, Consumo de alcohol, Consumo de Drogas, Salud mental, Salud Sexual y reproductiva. Objetivo Institucional: Disminuir la prevalencia de inactividad física en población en Chile, a través del curso de vida. Aumentar la seguridad alimentaria y nutricional en Chile, a través del curso de vida considerando diversidad territorial y pertinencia cultural. Reducir el consumo de alcohol en población general y sus consecuencias sociales y sanitarias. Disminuir el consumo de drogas en la población de Chile reduciendo sus consecuencias sociales y sanitarias. Disminuir la prevalencia de consumo de productos de tabaco y sistemas electrónicos de administración de nicotina y sin nicotina en la población. Mejorar la salud mental de la población en Chile con enfoque en lo promocional y preventivo. Abordar integralmente las necesidades en Salud Sexual y reproductiva de las personas a lo largo del curso de vida, desde un enfoque de género y de derechos.',
        ]);

        StrategicAxes::Create([
            'number'        => '3',
            'name'          => 'ENFERMEDADES NO TRANSMISIBLES',
            // 'description'   => 'Temas: Enfermedades Transmisibles en eliminación, Enfermedades Zoonóticas y vectoriales, Infecciones Respiratorias Agudas, Resistencia a los Antimicrobianos, Tuberculosis, VIH/SIDA. Objetivo Institucional: Disminuir el riesgo de reintroducción y/o aumento de enfermedades transmisibles en vías de eliminación. Reducir las enfermedades zoonóticas* y vectoriales* que afectan la salud de la población nacional. Disminuir la Morbimortalidad por Infecciones Respiratorias Agudas en la población a nivel nacional. Reducir el riesgo de emergencia y diseminación de Resistencia a los antimicrobianos. Reducir la incidencia de Tuberculosis en la población en Chile. Disminuir la incidencia de VIH/SIDA en Chile en la población entre 15 a 49 años',
        ]);

        StrategicAxes::Create([
            'number'        => '4',
            'name'          => 'ENFERMEDADES CRONICAS NO TRANSMISIBLES Y VIOLENCIA',
            // 'description'   => 'Temas: Cáncer, Diabetes mellitus, Enfermedad Renal Crónica, Enfermedades Cardiovasculares y Cerebrovasculares, Enfermedades Respiratorias Crónicas, Obesidad, Trastornos bucodentales, Violencia, Trastornos mentales. Objetivo Institucional: Disminuir la mortalidad prematura por cáncer en población general. Disminuir la prevalencia de diabetes mellitus en la población y complicaciones en personas con diabetes. Disminuir la prevalencia de enfermedad renal crónica en la población y sus complicaciones. Disminuir la carga de enfermedad por enfermedades cardiovasculares y cerebrovasculares en personas de 18 años y más en chile. Disminuir la carga de enfermedad por enfermedades respiratorias crónicas. Disminuir la prevalencia de obesidad y sobrepeso en la población. Mejorar el estado de salud bucal de la población a lo largo del curso de vida con enfoque de equidad en salud. Disminuir la prevalencia de violencias que afectan a las personas, familias y comunidades de manera diferenciada, según su género, curso de vida, etnia, nacionalidad, entre otros.  Reducir la carga de enfermedad asociada a la salud mental de la población a lo largo del curso de vida con enfoque de equidad.',
        ]);

        StrategicAxes::Create([
            'number'        => '5',
            'name'          => 'FUNCIONAMIENTO Y DISCAPACIDAD',
            // 'description'   => 'Temas: Accidentes de tránsito, Alteraciones Musculoesqueléticas, Artritis Reumatoide, Desarrollo Integral Infantil, Enfermedades Poco Frecuentes, Espectro Autista. Objetivo Institucional: Disminuir la tasa de morbimortalidad por accidentes de tránsito en la población nacional. Disminuir la prevalencia e incidencia de Alteraciones Músculo Esqueléticas, que genera dolor crónico y/o alteraciones funcionales en la población. Mantener la indemnidad y propiciar la ganancia funcional en personas con Artritis reumatoide. Disminuir la prevalencia de dependencia severa en la población nacional en todo el curso de vida. Disminuir la prevalencia de niños y niñas que no alcanzan su desarrollo integral acorde a su potencialidad.  Disminuir el impacto de las Enfermedades Poco Frecuentes (EPOF) en la calidad de vida de las personas, familias y comunidad que las presentan. Promover el desarrollo integral* y calidad de vida* de las personas en el espectro autista y sus familias a lo largo del curso de vida.',
        ]);

        StrategicAxes::Create([
            'number'        => '6',
            'name'          => 'EMERGENCIAS Y DESASTRES',
            // 'description'   => 'Temas: Cambio climático, Gestión del riesgo, emergencia y desastres. Objetivo Institucional: Disminuir el impacto negativo en la salud de la población por efecto del cambio climático. Mitigar los efectos de las emergencias y desastres* en la salud y bienestar de la población.',
        ]);

        StrategicAxes::Create([
            'number'        => '7',
            'name'          => 'GESTION, CALIDAD E INNOVACION',
            // 'description'   => 'Temas: Donación y trasplantes de órganos y tejidos, Financiamiento del sector, Gestión del personal, Infraestructura y equipamiento, Participación Social, Salud Digital, Seguridad y calidad de la atención, Tecnología e información en salud. Objetivo Institucional: Disminuir la tasa de morbimortalidad y mejorar la calidad de vida de las personas que requieren uno o más trasplantes de órganos y/o tejidos. Alinear el modelo de financiamiento a los objetivos sanitarios del país. Fortalecer el Diseño, Implementación y Monitoreo de un Modelo integral de Gestión y Desarrollo de Personas en el Sistema Público de Salud. Fortalecer la infraestructura y equipamiento del sector con enfoque de equidad dando respuesta a las necesidades de salud de la población. Fortalecer un modelo de gestión participativa en el área de la salud. Desarrollar un modelo de atención de Salud Digital* sostenible, que aporte al acceso, la atención oportuna y la información a los pacientes en sus contextos territoriales/culturales, de manera articulada, coordinada y que complemente al modelo de atención de salud presencial vigente. Fortalecer la entrega de servicios de salud con equidad, calidad y seguridad a la población.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tng_strategic_axes');
    }
};
