<?php

use Illuminate\Database\Seeder;
use App\OrganizationalUnit;


class OrganizationalUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ou0 = OrganizationalUnit::create(['name' => 'Dirección', 'organizational_unit_id' => NULL]);
            $ou1 = OrganizationalUnit::create(['name' => 'Subdirección de Gestion Asistencial', 'organizational_unit_id' => $ou0->id]);
                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Red de Salud Mental', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Gestión de Establecimientos y Dispositivos', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Gestión de Recursos de Salud Mental', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Modelo de Gestión de Salud Mental', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Redes Hospitalarias', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Servicios y Unidades de Apoyo Clínico', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Gestión de Demanda', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Gestión de Procesos Clínicos', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Gestión de Recursos e Inversiones', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de APS y Redes', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Salud Familiar', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Planes y Programas', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Gestión de Recursos e Inversiones', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Red de urgencias', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'S.A.M.U.', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Establecimientos de Red de Urgencias', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Planificación y Control de Redes', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Informática y Tecnología', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad Epidemiología', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Gestión de Información', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Gestión y Control', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Consultorio General Urbano Dr. Hector Reyno', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Gestión Administrativa', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Coordinador Médico', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Gestión Clínica', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Oficina de Información, Reclamos y Sugerencias (O.I.R.S.)', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'P.E.S.P.I.', 'organizational_unit_id' => $ou1->id]);
                $ou2 = OrganizationalUnit::create(['name' => 'P.R.A.I.S.', 'organizational_unit_id' => $ou1->id]);

            $ou1 = OrganizationalUnit::create(['name' => 'Subdirección de Recursos Físicos y Financieros', 'organizational_unit_id' => $ou0->id]);
                //$ou2 = OrganizationalUnit::create(['name' => 'Encargado de Gestión de Proyectos', 'organizational_unit_id' => $ou1->id]);
                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Gestión de Recursos Físicos e Inversiones de la Red', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Planificación de Análisis y Control de Equipos y Equipamiento de la Red', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Planificación de Análisis y Control de Infraestructura, Proyectos e Inversiones de la Red', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Gestión y Control de procesos y Administrativos de Inverciones', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Inspección Técnicas de Obras', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Gestión de Abastecimiento y Logística', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Planificación de Ejecución y Control de Abastecimiento, Obras, Equipo y Equipamiento', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Servicios Generales', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Gestión Financiera', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Planificación, Análisis y Control Financiera y Presupuestaria', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Cobranzas', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Sección de Contabilidad', 'organizational_unit_id' => $ou2->id]);

            $ou1 = OrganizationalUnit::create(['name' => 'Subdirección de Recursos Humanos', 'organizational_unit_id' => $ou0->id]);
                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Gestión de Recursos Humanos', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Personal y Ciclo de Vida laboral', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad Formación y Capacitación', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Reclutamiento y Selección de Personal', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Remuneraciones', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Calidad de Vida Laboral', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Bienestar', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Apoyo Social del Personal', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Clima Laboral', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Salud del Trabajador', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Departamento de Salud Ocupacional', 'organizational_unit_id' => $ou1->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Prevención de Riesgos', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Salud Ocupacional', 'organizational_unit_id' => $ou2->id]);
                    $ou3 = OrganizationalUnit::create(['name' => 'Unidad de Gestión Ambiental', 'organizational_unit_id' => $ou2->id]);

                $ou2 = OrganizationalUnit::create(['name' => 'Planificación y Control de Gestión de Recursos Humanos', 'organizational_unit_id' => $ou1->id]);

            $ou1 = OrganizationalUnit::create(['name' => 'Departamento de Auditoria Interna', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Departamento de Asesoría Jurídica', 'organizational_unit_id' => $ou0->id]);
                $ou2 = OrganizationalUnit::create(['name' => 'Unidad de Drogas', 'organizational_unit_id' => $ou1->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Departamento de Planificación y Control de Gestión', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Departamento de Relaciones Públicas y Comunicaciones', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Departamento de Participación Social, Gestión al usuario y Gobernanza', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Unidad de Secretaría y Oficina de Partes', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Unidad de Gestión del Riesgo en Emergencias y Desastres', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Unidad de Relaciones Laborales', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Unidad de Calidad y Seguridad del Paciente', 'organizational_unit_id' => $ou0->id]);
            $ou1 = OrganizationalUnit::create(['name' => 'Unidad de Relación Asistencial Docente', 'organizational_unit_id' => $ou0->id]);



    }
}
