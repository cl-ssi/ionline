<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddParametersPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Permission::create([
			'name' => 'Parameters: programs',
			'description' => 'Mantenedor de programas'
		]);

		Permission::create([
			'name' => 'Parameters: professions',
			'description' => 'Mantenedor de profesiones'
		]);
		
		Permission::create([
			'name' => 'Parameters: locations',
			'description' => 'Mantenedor de ubicaciones (edificios)'
		]);

		Permission::create([
			'name' => 'Parameters: places',
			'description' => 'Mantenedor de lugares (oficinas, pasillos, comedores, etc.)'
		]);

		Permission::create([
			'name' => 'Parameters: UNSPSC',
			'description' => 'Mantenedores de segmentos y productos del estandard UNSPSC que ocupa mercado público'
		]);

		Permission::create([
			'name' => 'Parameters: holidays',
			'description' => 'Mantenedor de días feriados'
		]);

		Permission::create([
			'name' => 'Parameters: COMGES cutoffdates',
			'description' => 'Mantenedor fecha de corte de COMGES'
		]);

    }
}
