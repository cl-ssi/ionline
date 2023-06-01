<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthService;

class HealthServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HealthService::create([
            'name' => 'Servicio de Salud Arica',
            'region_id' => 15
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Tarapacá',
            'region_id' => 1
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Antofagasta',
            'region_id' => 2
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Atacama',
            'region_id' => 3
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Coquimbo',
            'region_id' => 4
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Valparaíso-San Antonio',
            'region_id' => 5
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Viña del Mar-Quillota',
            'region_id' => 5
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Aconcagua',
            'region_id' => 5
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Metropolitano Norte',
            'region_id' => 13
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Metropolitano Occidente',
            'region_id' => 13
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Metropolitano Central',
            'region_id' => 13
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Metropolitano Sur',
            'region_id' => 13
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Metropolitano Oriente',
            'region_id' => 13
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Metropolitano Sur Oriente',
            'region_id' => 13
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Libertador B. O\'Higgins',
            'region_id' => 6
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud del Maule',
            'region_id' => 7
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Ñuble',
            'region_id' => 16
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Concepción',
            'region_id' => 8
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Arauco',
            'region_id' => 8
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Talcahuano',
            'region_id' => 8
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Biobío',
            'region_id' => 8
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Araucanía Norte',
            'region_id' => 9
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Araucanía Sur',
            'region_id' => 9
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Valdivia',
            'region_id' => 14
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Osorno',
            'region_id' => 10
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Reloncaví',
            'region_id' => 10
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Chiloé',
            'region_id' => 10
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Aysén',
            'region_id' => 11
        ]);
        HealthService::create([
            'name' => 'Servicio de Salud Magallanes',
            'region_id' => 12
        ]);

    }
}
