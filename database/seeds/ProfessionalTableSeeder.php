<?php

use Illuminate\Database\Seeder;
use App\Programmings\Professional;

class ProfessionalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Professional::Create(['name'=>'MEDICO','alias'=>'MEDICO']);
        Professional::Create(['name'=>'ENFERMERO','alias'=>'ENFERMERO']);
        Professional::Create(['name'=>'ODONTÓLOGO/A','alias'=>'ODONTÓLOGO/A']);
        Professional::Create(['name'=>'TENS ODONTÓLOGO','alias'=>'TENS ODONTÓLOGO']);
        Professional::Create(['name'=>'MATRON/A','alias'=>'MATRON/A']);
        Professional::Create(['name'=>'PSICOLOGO/A','alias'=>'PSICOLOGO/A']);
        Professional::Create(['name'=>'NUTRICIONISTA','alias'=>'NUTRICIONISTA']);
        Professional::Create(['name'=>'T. SOCIAL','alias'=>'T. SOCIAL']);
        Professional::Create(['name'=>'EDUCADORA DE PÁRVULOS','alias'=>'EDUCADORA DE PÁRVULOS']);
        Professional::Create(['name'=>'TERAPEUTA OCUPACIONAL','alias'=>'TERAPEUTA OCUPACIONAL']);
        Professional::Create(['name'=>'PROFESOR DE EDUCACION FÍSICA','alias'=>'PROFESOR DE EDUCACION FÍSICA']);
        Professional::Create(['name'=>'KINESIOLOGO/A','alias'=>'KINESIOLOGO/A']);
        Professional::Create(['name'=>'FONOAUDIOLOGO/A','alias'=>'FONOAUDIOLOGO/A']);
        Professional::Create(['name'=>'TENS','alias'=>'TENS']);
        Professional::Create(['name'=>'PODOLOGA','alias'=>'PODOLOGA']);
        Professional::Create(['name'=>'QUIMICO FARMACEÚTICO','alias'=>'QUIMICO FARMACEÚTICO']);
        Professional::Create(['name'=>'ADMINISTRATIVO','alias'=>'ADMINISTRATIVO']);
        Professional::Create(['name'=>'ING INFORMÁTICA','alias'=>'ING INFORMÁTICA']);
        Professional::Create(['name'=>'TECNICO DE REHABILITACIÓN EN DROGAS','alias'=>'MEDTECNICO']);
        Professional::Create(['name'=>'MEDICO ANDINO','alias'=>'MEDICO ANDINO']);
        Professional::Create(['name'=>'PARTERA','alias'=>'PARTERA']);
        Professional::Create(['name'=>'ING. COMERCIAL','alias'=>'ING. COMERCIAL']);
        Professional::Create(['name'=>'SERENO','alias'=>'SERENO']);
        Professional::Create(['name'=>'AUXILIAR DE SERVICIOS MENORES','alias'=>'AUXILIAR DE SERVICIOS MENORES']);
        Professional::Create(['name'=>'PARAMEDICO','alias'=>'PARAMEDICO']);
        Professional::Create(['name'=>'AGENTE COMUNITARIO','alias'=>'MEDICO']);

            
    }
}