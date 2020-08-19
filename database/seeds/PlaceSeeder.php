<?php

use Illuminate\Database\Seeder;
use App\Parameters\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Place::create([ 'name' => 'Oficina 211',
                        'description' => 'Gloriosa Oficina de SIDRA',
                        'location_id' => 2]);
        Place::create([ 'name' => 'Oficina 220',
                        'description' => 'Oficina de SIDRA Clínicos',
                        'location_id' => 2]);
    }
}
