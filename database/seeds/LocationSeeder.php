<?php

use Illuminate\Database\Seeder;
use App\Parameters\Location;

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
        Location::create([  'name' => 'Casa Central',
                            'address' => 'Anibal Pinto #815']);
        Location::create([  'name' => 'Bodega',
                            'address' => 'Obispo Labbé #962']);
        Location::create([  'name' => 'SDGDP',
                            'address' => 'Obispo Labbé']);
        Location::create([  'name' => 'Recursos Fisicos',
                            'address' => 'Obispo Labbé']);
    }
}
