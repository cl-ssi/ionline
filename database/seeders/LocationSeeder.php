<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Location::create([
            'name' => 'Casa Central',
            'address' => 'Anibal Pinto #815',
            'establishment_id' => 38
        ]);
        Location::create([
            'name' => 'Bodega',
            'address' => 'Obispo Labbé #962',
            'establishment_id' => 38
        ]);
        Location::create([
            'name' => 'SDGDP',
            'address' => 'Obispo Labbé',
            'establishment_id' => 38
        ]);
        Location::create([
            'name' => 'Recursos Fisicos',
            'address' => 'Obispo Labbé',
            'establishment_id' => 38
        ]);
    }
}
