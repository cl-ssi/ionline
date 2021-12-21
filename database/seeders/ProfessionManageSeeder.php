<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReplacementStaff\ProfessionManage;

class ProfessionManageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProfessionManage::Create(['name'=>'Administrativos(as)', 'profile_manage_id'=>'1']);

        ProfessionManage::Create(['name'=>'Auxiliares de Servicio – Cuidadores(as)', 'profile_manage_id'=>'2']);
        ProfessionManage::Create(['name'=>'Conductores', 'profile_manage_id'=>'2']);
        ProfessionManage::Create(['name'=>'Monitores(as)', 'profile_manage_id'=>'2']);

        ProfessionManage::Create(['name'=>'Contador(a) Auditor', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Enfermeras(os)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Fonoaudiólogo(a)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) Biomédico', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) Civil Industrial', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) Comercial', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) en Ejecución Administración de Empresas', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) en Ejecución Control de Gestión', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) Informático', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Ingeniero(a) Recursos Humanos', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Kinesiólogo(a)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Matronas(es)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Médicos Especialistas', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Médicos(as) Cirujanos', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Nutricionista', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Odontólogo(a)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Psicólogos(as)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Químico Farmacéutico(a)', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Tecnólogo(a) Médico', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Terapeuta Ocupacional', 'profile_manage_id'=>'3']);
        ProfessionManage::Create(['name'=>'Trabajadores(as) Sociales', 'profile_manage_id'=>'3']);

        ProfessionManage::Create(['name'=>'Técnico Social – Rehabilitación', 'profile_manage_id'=>'4']);
        ProfessionManage::Create(['name'=>'Técnicos en Administración', 'profile_manage_id'=>'4']);
        ProfessionManage::Create(['name'=>'Técnicos en Farmacia', 'profile_manage_id'=>'4']);
        ProfessionManage::Create(['name'=>'Técnicos en Nivel Medio Enfermería (Técnicos Paramédicos)', 'profile_manage_id'=>'4']);
        ProfessionManage::Create(['name'=>'Técnicos en Nivel Superior en Enfermería (TENS)', 'profile_manage_id'=>'4']);
        ProfessionManage::Create(['name'=>'Técnicos en Odontología - Higienista Dental ', 'profile_manage_id'=>'4']);
        ProfessionManage::Create(['name'=>'Técnicos en Personal/RRHH ', 'profile_manage_id'=>'4']);
    }
}
