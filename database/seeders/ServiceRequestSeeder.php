<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRequests\ServiceRequest;
use Carbon\Carbon;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequest::create([
            'id' => '1',
            'type' => 'Covid',
            'subdirection_ou_id' => '31',
            'responsability_center_ou_id' => '222',
            'responsable_id' => '15287582',
            'address' => 'Iquique',
            'phone_number' => '912345678',
            'email' => 'sistemas.ssi@redsalud.gob.cl',
            'request_date' => '2022-01-01 00:00:00',
            'start_date' => '2022-01-01 00:00:00',
            'end_date' => '2022-01-31 00:00:00',
            'contract_type' => 'NUEVO',
            'service_description' => 'Prestará servicios de enfermería realizando las funciones descritas en el Manual de Organización interno, en el contexto de pandemia Covid',
            'programm_name' => 'Covid19 Médicos',
            'other' => 'Brecha',
            'program_contract_type' => 'Mensual',
            'weekly_hours' => '44,00',
            'estate' => 'Profesional Médico',
            'working_day_type' => 'DIURNO',
            'schedule_detail' => 'DIURNO DE LUNES A VIERNES (DESDE LAS 08:00 HRS HASTA LAS 16:48 HRS)',
            'establishment_id' => '1',
            'profession_id' => '4',
            'digera_strategy' => 'Camas MEDIAS Aperturadas',
            'rrhh_team' => 'Residencia Médica',
            'signature_page_break' => '0',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now(),
            'creator_id' => '15287582'
        ]);
    }
}
